# Use official PHP image
FROM php:8.2-cli

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create and set working directory inside the container
WORKDIR /app

# Copy composer files first (for build cache)
COPY composer.json composer.lock* ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of your application code
COPY . .

# Expose port Render expects
EXPOSE 10000

# Start PHP built-in server from /app
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
