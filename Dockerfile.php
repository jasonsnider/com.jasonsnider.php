# Stage 1: Build stage
FROM composer:latest AS build

WORKDIR /app

# Copy the composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Stage 2: Production stage
FROM php:7.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy the application code
COPY . /app

# Copy the vendor directory from the build stage
COPY --from=build /app/vendor /app/vendor

# Ensure Composer's global bin directory is in the PATH
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]