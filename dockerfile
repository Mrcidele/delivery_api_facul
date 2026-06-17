# Use the official PHP image with Apache pre-installed
FROM php:8.2-apache

# Install common PHP extensions that most projects need (PDO, MySQL, etc.)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite (crucial for frameworks like Laravel or custom routing)
RUN a2enmod rewrite

# Set the working directory inside the container to Apache's default public folder
WORKDIR /var/www/html

# Copy your local project files into the container
COPY . /var/www/html/

# Change ownership of the files so Apache can read/write them properly
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 (the standard web port)
EXPOSE 80