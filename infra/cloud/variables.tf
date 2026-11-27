variable "region" {
  description = "Laravel Cloud region. The plan fails with the valid ones listed when this isn't one of them."
  type        = string
}

variable "php_version" {
  description = "PHP version in Laravel Cloud's \"major:minor\" form, e.g. \"8.4:1\". Must satisfy the PHP constraint in composer.json."
  type        = string
}

variable "instance_size" {
  description = "Instance size. The plan fails with the valid ones listed when this isn't one of them."
  type        = string
}

variable "custom_domain" {
  description = "Custom domain to attach, e.g. semver.madewithlove.com. Leave null to serve only on the laravel.cloud domain."
  type        = string
  default     = null
}

variable "app_key" {
  description = "Laravel APP_KEY (base64:...). Comes from TF_VAR_app_key, set in Terrace from 1Password."
  type        = string
  sensitive   = true
}
