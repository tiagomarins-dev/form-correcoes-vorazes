FROM php:8.2-apache

# Set timezone to Brazil/Sao Paulo
ENV TZ=America/Sao_Paulo
RUN apt-get update && apt-get install -y tzdata curl \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install additional PHP extensions if needed
RUN docker-php-ext-install pdo pdo_mysql

# Set PHP timezone
RUN echo "date.timezone = America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 (will be mapped to 6050)
EXPOSE 80