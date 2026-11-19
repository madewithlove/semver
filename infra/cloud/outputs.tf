output "environment_id" {
  value = laravel_cloud_environment.production.id
}

output "environment_status" {
  value = laravel_cloud_environment.production.status
}

output "custom_domain_action_required" {
  description = "What Laravel Cloud still needs before the custom domain works, if anything."
  value       = one(laravel_cloud_domain.custom[*].action_required)
}

output "custom_domain_dns_records" {
  description = "The DNS records to create for the custom domain."
  value       = one(laravel_cloud_domain.custom[*].dns_records)
}
