# Use official PHP image
FROM php:8.2-cli

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /

# Copy everything
COPY . .

# Install dependencies
RUN composer install

# Expose port Render expects
EXPOSE 10000

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
