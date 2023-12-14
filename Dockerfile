
FROM php:8.2-apache


RUN apt-get update && \
    apt-get install -y libpq-dev libzip-dev zip && \
    docker-php-ext-install pdo_pgsql pdo_mysql zip


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN apt-get install -y git


RUN a2enmod rewrite


COPY . /var/www/html


RUN cd /var/www/html/ && \
    composer install --no-dev --optimize-autoloader


EXPOSE 80

CMD ["apache2-foreground"]





