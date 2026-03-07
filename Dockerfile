# =======================================
# Stage 1 - Build Frontend React (Vite)
# =======================================
FROM node:18 AS frontend

WORKDIR /app

# Copier uniquement les fichiers nécessaires pour npm install
COPY package*.json ./

# Installer les dépendances
RUN npm install

# Copier tout le frontend
COPY . .

# Build production
RUN npm run build

# =======================================
# Stage 2 - Backend Laravel + PHP
# =======================================
FROM php:8.2-cli

# Installer dépendances système et extensions PHP
RUN apt-get update && apt-get install -y \
    git curl unzip libonig-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev libicu-dev libpq-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql pdo pdo_pgsql pgsql mbstring zip gd bcmath intl exif pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Répertoire de travail Laravel
WORKDIR /var/www/html

# Copier tout le backend
COPY . .

# Copier le build frontend dans public/build
COPY --from=frontend /app/public/build ./public/build

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Nettoyer les caches Laravel
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Permissions pour storage et cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Exposer le port utilisé par php artisan serve
EXPOSE 8080

# Lancer migration + serveur Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080