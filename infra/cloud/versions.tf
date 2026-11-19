terraform {
  required_version = ">= 1.5"

  # State lives in Terrace, which fills in the address and credentials.
  backend "http" {}

  required_providers {
    laravel = {
      source  = "laravel/laravel"
      version = "~> 1.3"
    }
  }
}

# Reads LARAVEL_CLOUD_API_TOKEN, which Terrace provides from 1Password.
provider "laravel" {}
