# Cyberin Laravel hosting guide

## 1. Runtime requirements

Select PHP 8.2 or newer (PHP 8.3 recommended). Enable: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PDO, PDO MySQL, Tokenizer, XML, XMLReader, XMLWriter and Zip. MySQL 8.0+ or compatible MariaDB is recommended.

## 2. Create the MySQL database

In the Cyberin control panel, create a database and a database user. Grant the user all privileges on only that database. Retain host, port, database, username and password for `.env`.

## 3. Upload the project

Upload and extract `BIC_Laravel_Production_Source.zip` outside the public web directory when the panel permits it. Do not upload a local `.env`, `node_modules`, tests or secrets. Run `composer install --no-dev --optimize-autoloader` from the project root.

## 4. Document root

Set the domain document root to the Laravel project's `public/` directory. The domain must never point at the project root. If the host cannot change document root, ask Cyberin support to map it; do not copy `index.php` around or expose `app/`, `config/`, `storage/` or `.env`.

## 5. Environment setup

Copy `.env.example` to `.env` on the server. Set `APP_URL` to the final HTTPS URL, insert MySQL credentials, keep `APP_ENV=production` and `APP_DEBUG=false`, and set `SESSION_SECURE_COOKIE=true` after SSL is active. Restrict `.env` permissions to the account user.

## 6. Application key

Run `php artisan key:generate --force` once. Back up the generated `APP_KEY`; changing it later invalidates encrypted sessions and data.

## 7. Database and initial content

Run `php artisan migrate --force`, then `php artisan db:seed --class=InsightSeeder --force`. Create the first administrator interactively with `php artisan bic:admin-create admin@example.com --name="Administrator"`. The command requests a hidden password and no real password is stored in source.

## 8. Storage and permissions

Run `php artisan storage:link` for public CMS cover images. Uploaded inquiry PDFs remain under private `storage/app/private` through the local disk and are never linked publicly. Grant the web process write access only to `storage/` and `bootstrap/cache/` (typically 775 directories and 664 files under the account group). Do not use 777.

## 9. Frontend assets

The package includes `public/build/`. If rebuilding on the server, use Node 20+ and run `npm ci && npm run build`; `node_modules` is not required afterward.

## 10. Production optimisation

After `.env`, dependencies and migrations are correct, run:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Repeat the cache commands after configuration or route changes.

## 11. Domain and SSL

Point DNS to the Cyberin hosting account, attach the domain to the `public/` document root, issue or import an SSL certificate, force HTTPS at the hosting layer, and verify canonical URLs use the final domain. Test `/`, all five `/apply/*` routes, `/insights`, `/admin/login`, `/robots.txt` and `/sitemap.xml`.

## 12. Backups

Schedule daily MySQL backups and regular copies of `.env`, `storage/app/private`, `storage/app/public` and the deployed release. Encrypt off-site backups and define retention. Test restore procedures periodically.

## 13. Deployment and rollback

Use timestamped release directories. Before deployment, back up the database and storage. Put the site into maintenance mode, deploy code, install locked dependencies, run migrations, switch the `current` symlink/document root, clear and rebuild caches, then run smoke tests and `php artisan up`.

For rollback, restore the prior release pointer. If a migration is not backward compatible, restore the matching database backup; do not blindly run `migrate:rollback` on production data. Restore matching storage if uploads changed. Confirm the homepage, forms, admin and Insights before ending maintenance.

