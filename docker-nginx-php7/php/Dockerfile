FROM php:fpm
COPY php.ini /usr/local/etc/php/
RUN apt-get update && \
    # PHPのExtensionをインストール．
    docker-php-ext-install pdo_mysql mbstring

RUN echo '\
    log_errors = On\n\
    error_log = /dev/stderr\n\
    error_reporting = E_ALL\n\
    ' >> /usr/local/etc/php/php.ini

WORKDIR /chat

EXPOSE 80

