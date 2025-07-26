# Use official PHP image
FROM php:8.2-cli

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql
    
# Create and set working directory inside the container
WORKDIR /app

# Copy the rest of your application code
COPY . .

# Expose port Render expects
EXPOSE 10000

# Start PHP built-in server from /app
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
