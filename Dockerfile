FROM php:8.2-cli

# Installer dépendances système + PostgreSQL
RUN apt-get update && apt-get install -y \
    git curl unzip libonig-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql pgsql mbstring zip gd bcmath exif pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier le projet
COPY . .

# Installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Nettoyer cache Laravel
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear \
 && php artisan cache:clear

# Permissions
RUN chmod -R 777 storage bootstrap/cache || true

EXPOSE 8080

# Démarrage
CMD php artisan migrate --force && \
    php artisan db:seed --class=SuperAdminSeeder --force && \
    php artisan serve --host=0.0.0.0 --port=8080