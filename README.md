# Bridge India Capital — Laravel production source

Laravel 12 / PHP 8.2+ / Blade / MySQL / Vite implementation of the approved BIC frontend.

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
# use a local MySQL database, or SQLite for development/tests
php artisan migrate --seed
npm ci
npm run build
php artisan serve
```

Create an administrator with `php artisan bic:admin-create you@example.com --name="Your Name"`. No password is committed or seeded.

See `docs/MIGRATION_MAP.md`, `docs/CYBERIN_LARAVEL_HOSTING_GUIDE.md` and `docs/ADMIN_USER_GUIDE.md`.
