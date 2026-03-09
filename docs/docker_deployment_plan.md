# Docker Deployment Strategy

## Overview
This document outlines how to build and spin up the `dpadmin` application in a containerized environment using Docker. The configuration relies on `docker-compose` to orchestrate Nginx, PHP-FPM, and MySQL together.

## File Breakdown

1. **`Dockerfile`**: Sets up the `php:7.4-fpm` (or `8.1-fpm` based on compatibility) image. It installs required system dependencies, PHP extensions used by Laravel (pdo, mbstring, exif, bcmath, gd), and gets the latest Composer.
2. **`docker-compose.yml`**: Defines the services.
   - `app`: Builds the PHP-FPM image based on the `Dockerfile`.
   - `web`: Uses official `nginx:alpine` and mounts the configuration file.
   - `db`: Uses `mysql:5.7` to host the application database.
3. **`docker/nginx/conf.d/app.conf`**: The Nginx vhost routing all PHP requests strictly to the `app` container via FastCGI and configuring `public_html/public` as the document root.

## Deployment Steps

0. **Database Backup (Before Deployment):**
   Prior to migrating or spinning up the Docker environment, you should back up the existing database from your current VPS/cPanel hosting.
   - Using MySQL dump (via SSH on the old VPS):
     ```bash
     mysqldump -u current_db_user -p current_database_name > dpadmin_dtdp_09032026.sql
     ```
   - Place the exported `dpadmin_dtdp_09032026.sql` file into your local `/tmp/` directory so it looks like `/tmp/dpadmin_dtdp_09032026.sql`

1. **Environment Setup:** Ensure you have `.env` copied from `.env.example`.
   - Update `DB_HOST=db` (matches the `db` service name in docker-compose)
   - Set `DB_DATABASE=dpadmin`, `DB_USERNAME=dpadmin`, `DB_PASSWORD=secret`.
2. **Build and Spin up:**
   ```bash
   cd public_html
   docker-compose up -d --build
   ```
3. **Install Dependencies & Restore Database:**
   Enter the PHP container to install composer and NPM packages.
   ```bash
   docker-compose exec app bash
   composer install
   npm install && npm run dev
   php artisan key:generate
   ```
   *Note: Instead of running `php artisan migrate`, restore the database backup into your fresh MySQL container:*
   ```bash
   # Restore directly from the absolute path /tmp/dpadmin_dtdp_09032026.sql on your host machine
   docker-compose exec -T db mysql -u dpadmin -psecret dpadmin < /tmp/dpadmin_dtdp_09032026.sql
   ```
4. **Permissions:**
   Fix the folder permissions so the server can write securely to `storage` and `bootstrap/cache`.
   ```bash
   docker-compose exec app chown -R www-data:www-data storage bootstrap/cache public/upload
   ```

You can now reach your application at `http://localhost:8080` (or whichever port maps to port 80).
