FROM php:8.0-fpm

ENV TZ="America/Sao_Paulo"
ENV ACCEPT_EULA=Y

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

USER root

RUN apt-get update \
    && apt-get install -y --no-install-recommends --no-install-suggests \
    build-essential \
    curl \
    libcurl4-gnutls-dev \
    libzip-dev \
    libssl-dev \
    ca-certificates \
    libxml2-dev \
    libpq-dev \
    apt-transport-https \
    zip \
    unzip \
    supervisor \
    nginx

RUN pecl install redis xdebug

RUN docker-php-ext-install pdo pdo_pgsql intl curl bcmath zip xml && \
    docker-php-ext-enable redis xdebug

# instalar o composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY docker/nginx /etc/nginx
COPY docker/php/php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini
COPY docker/supervisord.conf /etc/supervisord.conf

# fix permissions
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN mkdir /var/run/nginx && chown -R www-data:www-data /var/run/nginx /var/log/nginx /var/lib/nginx /var/www

USER www-data

ADD . /var/www/html

WORKDIR "/var/www/html"

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

EXPOSE 80