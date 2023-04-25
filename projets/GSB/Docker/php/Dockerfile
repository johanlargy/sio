FROM php:apache

RUN apt-get update && apt-get install -y git curl zip unzip libonig-dev
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mbstring
