# Copilot Instructions — bluem-woocommerce

## Project overview

WordPress + WooCommerce plugin providing Bluem payment, eMandates and iDIN identity services.  
PHP 8.0+, using the `bluem-development/bluem-php` SDK. Licensed GPL v3.

## Repository layout

| Path | Purpose |
|---|---|
| `bluem.php` | Main plugin entry point (WP plugin header) |
| `bluem-*.php` | Feature modules (payments, mandates, iDIN, login, etc.) |
| `gateways/` | WooCommerce payment gateway classes |
| `src/` | Namespaced PHP classes (`Bluem\Wordpress\…`) |
| `views/` | Admin page templates |
| `css/`, `js/` | Front-end assets |
| `tests/Unit/`, `tests/Acceptance/` | PHPUnit + Codeception tests |
| `docker-compose.yml` | Local dev env (MySQL 5.7, WordPress, phpMyAdmin) |
| `svn-directory/` | WordPress.org SVN checkout for plugin releases |
| `build/` | Generated build output (do **not** edit directly) |
| `Makefile` | Dev & release tasks (see below) |

## Key commands

```sh
make install            # composer install
make unit_test          # PHPUnit
make acceptance_test    # Codeception
make lint               # php-cs-fixer check
make lint_fix           # php-cs-fixer fix
make copy-to-docker     # build & copy plugin into Docker env
make prepare-release NEW_TAG=x.y.z   # build, tag, update trunk (SVN)
make release            # commit prepared release to WP SVN
```

## Coding conventions

- `declare(strict_types=1);` in all PHP files.
- Follow WordPress Coding Standards (WPCS) and PSR-12 where compatible.
- Use typed properties, return types, union types, readonly, enums (PHP 8.x).
- WordPress globals and hooks: use `add_action` / `add_filter`; avoid direct DB queries — use `$wpdb` with prepared statements.
- WooCommerce gateway classes extend `WC_Payment_Gateway`.
- Escape all output (`esc_html`, `esc_attr`, `wp_kses_post`). Sanitise all input (`sanitize_text_field`, `absint`, etc.).

## Release workflow

1. Bump version in `bluem.php` plugin header and `build.env`.
2. `make prepare-release NEW_TAG=x.y.z` — builds into `build/`, copies to `svn-directory/tags/` and `svn-directory/trunk/`.
3. `make release` — commits tag + trunk to WordPress.org SVN.

## Things to watch out for

- `build/` and `svn-directory/` are deployment artifacts; never edit them directly.
- Docker volumes live under `docker/`; plugin code is mounted via `docker/plugins/`.
- The plugin depends on `bluem-development/bluem-php` — check its API when suggesting SDK calls.
- Keep WP compatibility ≥ 5.0 and WC compatibility reasonable.

