# Usa un'immagine di base con PHP e Apache
FROM php:8.2-apache

# Aggiorna il sistema e installa le dipendenze necessarie
RUN apt-get update && \
    apt-get install -y libpq-dev libzip-dev zip && \
    docker-php-ext-install pdo_pgsql pdo_mysql zip

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installa Git
RUN apt-get install -y git

# Abilita il modulo rewrite di Apache
RUN a2enmod rewrite

# Copia i file del progetto nel container
COPY . /var/www/html

# Esegui Composer install con --no-dev per l'ambiente di produzione
RUN cd /var/www/html/ && \
    composer install --no-dev --optimize-autoloader

# Esponi la porta 80 per il web server Apache
EXPOSE 80

# Comando di avvio del container
CMD ["apache2-foreground"]





