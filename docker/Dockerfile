FROM php:8.2.18-apache-bullseye
LABEL maintainer "kendal.alfonso37@gmail.com"

#Instalando Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.overload_var_dump=On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && docker-php-ext-install opcache \
    && docker-php-ext-enable opcache \
    && echo "opcache.file_cache = /var/www/html/.opcache" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

#Instalando apc
RUN printf "\n" | pecl install apcu \
    && echo extension=apcu.so > /usr/local/etc/php/conf.d/apcu.ini

# Instalando Paquetes faltantes
RUN apt-get update \
    && apt-get install -y nano zip libzip-dev libpq-dev zlib1g-dev libicu-dev g++ libxml2-dev memcached libmemcached-dev \
    wkhtmltopdf freetds-bin freetds-common wget lsb-release gnupg libxslt1-dev libpng-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-install intl xml gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install xsl

# Instalando mysqli
RUN docker-php-ext-install mysqli pdo_mysql

COPY php.ini /usr/local/etc/php/

# Instalando memcached
RUN pecl install memcached \
    && docker-php-ext-enable memcached

#Instalando Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"


ADD 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN chmod -R 755 /var/www/html

RUN chown -R www-data:www-data /var/www/html/
RUN mkdir -p storage/logs storage/framework storage/app bootstrap/cache
RUN chmod -R 777 /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN a2enmod rewrite
RUN a2enmod headers

RUN useradd -ms /bin/bash kendal

EXPOSE 80
EXPOSE 443

EXPOSE 3306
