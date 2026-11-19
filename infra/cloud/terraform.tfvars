# Checked at plan time against what Laravel Cloud offers: a wrong value fails the plan with the valid ones listed.
region        = "eu-central-1"
php_version   = "8.4:1"
instance_size = "flex.c-1vcpu-256mb"

# Set once the app works on its laravel.cloud domain, then add the DNS records from the outputs.
custom_domain = null
