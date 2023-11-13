FROM php:8.2-fpm

WORKDIR /app

RUN apt-get update

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    mv composer.phar /usr/local/bin/composer && \
    php -r "unlink('composer-setup.php');"

RUN pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash \
    && apt install symfony-cli -y 

EXPOSE 8000

CMD ["symfony", "server:start", "--no-tls"]


