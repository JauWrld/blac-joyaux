FROM php:8.3-cli

WORKDIR /var/www/html

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_sqlite

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie du projet
COPY . .

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installation des dépendances JS et compilation Vite
RUN npm install && npm run build

# Création de la base SQLite
RUN touch database/database.sqlite

# Création des tables Laravel
RUN php artisan migrate --force



# Lien storage
RUN php artisan storage:link || true

# Cache Laravel
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080
