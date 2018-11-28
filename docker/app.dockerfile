FROM php:7.1.16-fpm

RUN apt-get update && apt-get install -y git zip unzip libmcrypt-dev \
    mysql-client libmagickwand-dev libzip-dev --no-install-recommends \
    && pecl install imagick \
    && pecl install zip \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install mcrypt pdo_mysql zip
RUN apt-get install -y npm nodejs nodejs-legacy
RUN npm install bower -g
RUN apt-get install -yf vim
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"
COPY ./cert_APV_CERT.crt /usr/local/share/ca-certificates/
COPY ./php-upload.ini /usr/local/etc/php/conf.d/
COPY ./php-datetime.ini /usr/local/etc/php/conf.d/
RUN update-ca-certificates
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get install -y tzdata
RUN ln -fs /usr/share/zoneinfo/Asia/Ho_Chi_Minh  /etc/localtime
RUN dpkg-reconfigure --frontend noninteractive tzdata
RUN apt-get install -yf cron
WORKDIR /var/www