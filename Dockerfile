FROM prooph/composer:7.2

COPY . /usr/src/mapper
WORKDIR /usr/src/mapper

RUN composer install -n
