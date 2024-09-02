# Dockerfile

# Use an official PHP image as a parent image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Copy project files into the container
COPY . .

# Install dependencies, composer, and Symfony CLI
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Expose port 8000 and start Symfony server
EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]