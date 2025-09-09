# 1) Use official PHP image
FROM php:8.2-fpm

# 2) Install system dependencies + PostgreSQL client libraries
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libfreetype6-dev zip unzip \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql gd

# 3) Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4) Set working directory
WORKDIR /var/www

# 5) Copy project files
COPY . .

# 6) Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 7) Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 8) Expose port
EXPOSE 8000

# 9) Run entrypoint script
ENTRYPOINT ["docker-entrypoint.sh"]
