FROM php:7
MAINTAINER Miroslav Cillik <miro@keboola.com>

# Dependencies
RUN apt-get update
RUN apt-get install -y wget curl make git bzip2 time libzip-dev zip unzip libssl1.0.0 openssl vim

# Composer
WORKDIR /root
RUN cd \
  && curl -sS https://getcomposer.org/installer | php \
  && ln -s /root/composer.phar /usr/local/bin/composer

# Main
ADD . /code
WORKDIR /code
RUN echo "memory_limit = -1" >> /etc/php.ini
RUN composer install --no-interaction

CMD php ./src/run.php --data=/data

