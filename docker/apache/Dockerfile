FROM php:8.2-apache

# Enable Apache Rewrite module
RUN a2enmod rewrite

# Set the document root
WORKDIR /var/www/html

# Install system dependencies and Composer
RUN apt-get update && apt-get install -y \
    libmagickwand-dev \
    libpng-dev \
    libzip-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get install -y p7zip \
    p7zip-full \
    zip \
    unzip

# Install ImageMagick and Imagick extension
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# Copy project files to the container
COPY . /var/www/html

# Copy the .htaccess file
COPY .htaccess /var/www/html/.htaccess

# Set the server name
ENV SERVER_NAME localhost

# Expose the Apache port
EXPOSE 80

# Start Apache service
CMD ["apache2-foreground"]

# Run tests
 RUN composer install --no-interaction --optimize-autoloader --no-scripts --no-plugins \
    && ./vendor/bin/phpunit