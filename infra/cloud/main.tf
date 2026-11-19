data "laravel_cloud_regions" "available" {}

data "laravel_cloud_instance_sizes" "available" {}

locals {
  region_names = [for region in data.laravel_cloud_regions.available.regions : region.name]
  size_names   = [for size in data.laravel_cloud_instance_sizes.available.sizes : size.name if size.instance_class == "general"]
  app_url      = var.custom_domain != null ? "https://${var.custom_domain}" : null
}

resource "laravel_cloud_application" "semver" {
  name                         = "semver"
  repository                   = "madewithlove/semver"
  region                       = var.region
  source_control_provider_type = "github"

  lifecycle {
    precondition {
      condition     = contains(local.region_names, var.region)
      error_message = "Region \"${var.region}\" isn't available. Pick one of: ${join(", ", local.region_names)}."
    }
  }
}

resource "laravel_cloud_environment" "production" {
  application_id      = laravel_cloud_application.semver.id
  name                = "production"
  branch              = "main"
  uses_push_to_deploy = true

  php_version  = var.php_version
  node_version = "22"

  build_command = <<-EOT
    composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
    npm ci
    npm run build
  EOT

  # No database, so no migrations: only cache the config, routes and views.
  deploy_command = "php artisan optimize"
}

resource "laravel_cloud_instance" "web" {
  environment_id = laravel_cloud_environment.production.id
  name           = "web"
  size           = var.instance_size
  scaling_type   = "custom"
  min_replicas   = 1
  max_replicas   = 1

  # Only the framework's example "inspire" command is scheduled.
  uses_scheduler = false

  lifecycle {
    precondition {
      condition     = contains(local.size_names, var.instance_size)
      error_message = "Instance size \"${var.instance_size}\" isn't available. Pick one of: ${join(", ", local.size_names)}."
    }
  }
}

resource "laravel_cloud_environment_variables" "production" {
  environment_id = laravel_cloud_environment.production.id

  variables = merge(
    {
      APP_NAME  = "SemVer"
      APP_ENV   = "production"
      APP_DEBUG = "false"
      APP_KEY   = var.app_key

      LOG_CHANNEL = "stderr"
      LOG_LEVEL   = "warning"

      # The app has no database, so neither may use Laravel's "database" default.
      # The file cache only holds an hour of Packagist responses and may be lost on deploy.
      CACHE_STORE    = "file"
      SESSION_DRIVER = "cookie"
    },
    local.app_url != null ? { APP_URL = local.app_url } : {},
  )
}

resource "laravel_cloud_domain" "custom" {
  count = var.custom_domain != null ? 1 : 0

  environment_id = laravel_cloud_environment.production.id
  name           = var.custom_domain
}
