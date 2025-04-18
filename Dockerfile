
FROM php:8.1-apache

RUN docker-php-ext-install mysqli


COPY . /var/www/html

# Atur izin file untuk Apache
RUN chown -R www-data:www-data /var/www/html

#  port 80ko
EXPOSE 80
