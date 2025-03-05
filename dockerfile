FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Install dependencies
RUN docker-php-ext-install pdo pdo_mysql

# Expose port
EXPOSE 8080

# Start the PHP server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]