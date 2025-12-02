# Dockerfile pour le projet EcoRide
# Construit une image PHP 8.2 + Apache, installe les paquets système requis,
# extensions PHP (PDO/MySQL, zip) et Composer. Le répertoire public/ est utilisé comme document root.
FROM php:8.2-apache

# Installer les dépendances système et les extensions PHP
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Définir le document root Apache sur public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier les fichiers composer pour bénéficier du cache lors du build
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copier les fichiers du projet
COPY . .

# Définir les permissions appropriées pour l'utilisateur www-data
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
