# Laravel Cloud

This folder runs semver.madewithlove.com on Laravel Cloud, using the
[Laravel Cloud provider](https://github.com/laravel/terraform-provider-laravel) (beta). Terrace plans
pull requests that change it and applies them after they're merged into `main`, so nobody needs a
Laravel Cloud account to change it.

| File | What |
| --- | --- |
| `main.tf` | The application, its `production` environment (deployed on push to `main`), one web instance, environment variables and the optional custom domain |
| `terraform.tfvars` | Region, PHP version, instance size and custom domain |
| `variables.tf` | The inputs, `app_key` among them, which only Terrace provides |
| `outputs.tf` | Environment status, and the DNS records the custom domain needs |

## Setting it up in Terrace (once)

1. Install the Terrace GitHub App on `madewithlove/semver`.
2. On the repo's page in Terrace, add the root `infra/cloud` and these provider credentials:

   | Variable | Value | Used for |
   | --- | --- | --- |
   | `LARAVEL_CLOUD_API_TOKEN` | `op://` reference to the Laravel Cloud token | Plans and applies (or a read-only token for plans and the write token for applies only) |
   | `TF_VAR_app_key` | `op://` reference to the app's `APP_KEY`, for example the one from the Forge site | Plans and applies |

3. Choose the approvers, or apply on merge.

Laravel Cloud must have access to the `madewithlove` GitHub organisation, because Cloud builds the
code from the repository itself. Someone with access to Laravel Cloud connects it once. Without that,
creating the application fails.

## Moving over from Forge

1. Merge with `custom_domain = null`. Cloud creates the app and deploys `main` to its
   `*.laravel.cloud` domain. Check the site there: search, a version check, and assets over HTTPS.
2. Lower the TTL of the `semver.madewithlove.com` DNS record.
3. Set `custom_domain = "semver.madewithlove.com"` and merge. The plan's outputs
   `custom_domain_dns_records` and `custom_domain_action_required` say what to add at the DNS
   provider.
4. Once the domain is verified and serves from Cloud, remove the site from Forge.

## Known unknowns

- **PHP 8.5.** `main` requires PHP `^8.4`, so this deploys `8.4:1`. Before the PHP 8.5 bump is merged,
  check that Cloud offers 8.5 and change `php_version` in the same pull request.
- **Region and instance size** are checked against what Cloud offers when planning. A value that
  doesn't exist fails the plan and lists the valid values.
- **Trusted proxies.** Cloud serves the app behind a proxy. If assets or Livewire requests come out
  as `http://`, trust the proxy in `bootstrap/app.php` (`$middleware->trustProxies(at: '*')`).
- **Environment variables** set by hand in Cloud may be left alone or removed on apply. The
  provider's documentation says both, so set them here.
