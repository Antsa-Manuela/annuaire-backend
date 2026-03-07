FROM php:8.2-cli

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip libonig-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd bcmath exif pcntl

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dossier de travail
WORKDIR /var/www/html

# Copier le projet
COPY . .

# Installer dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Nettoyer cache
RUN php artisan config:clear \
 && php artisan route:clear \
 && php artisan view:clear

# Permissions
RUN chmod -R 777 storage bootstrap/cache

# Port Render
EXPOSE 8080

# Lancer Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080