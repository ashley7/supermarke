FROM php:7.2.7-apache

ARG uid=1000
RUN useradd -G www-data,root -u $uid -d /home/testuser testuser
RUN mkdir -p /home/testuser/.composer && \
    chown -R testuser:testuser /home/testuser

RUN apt-get update --fix-missing -q
RUN apt-get install -y libpng-dev curl mcrypt gnupg build-essential software-properties-common wget vim zip unzip

RUN docker-php-ext-install gd mbstring pdo pdo_mysql

RUN curl -sSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html/

# Run composer to build dependencies in vendor folder
RUN composer install --no-scripts --no-suggest --no-interaction --prefer-dist --optimize-autoloader 

RUN composer dump-autoload --optimize --classmap-authoritative

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf 

# Set container's working dir
WORKDIR /var/www/html/

RUN touch database/database.sqlite && \
    cp .env.example .env && \
    php artisan config:cache && \
    php artisan config:clear && \
    php artisan key:generate && \
    chown -R www-data:www-data . && \
    chmod -R 755 . && \
    chmod -R 775 storage/framework/ && \
    chmod -R 775 storage/logs/ && \
    chmod -R 775 bootstrap/cache/  


CMD ["/usr/sbin/apache2", "-DFOREGROUND"]