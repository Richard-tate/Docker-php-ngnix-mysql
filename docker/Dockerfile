FROM php:8.0-alpine
# Base image for PHP change as needed

# Install extensions and dependencies, add as per your requirement
RUN docker-php-ext-install pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
