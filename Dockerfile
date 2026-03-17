FROM php:8.2-cli

# Installer dépendances système + extensions PHP (avec pdo_mysql)
RUN apt-get update && apt-get install -y \
    git curl unzip libonig-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd bcmath exif pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer (depuis l'image officielle)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier le projet
COPY . .

# Installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Nettoyer cache
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

# Permissions
RUN chmod -R 777 storage bootstrap/cache || true

EXPOSE 8080

# Démarrage : migrations, seeder, puis serveur
CMD php artisan migrate --force && \
    php artisan db:seed --class=SuperAdminSeeder --force && \
    php artisan serve --host=0.0.0.0 --port=8080