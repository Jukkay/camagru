FROM phpdockerio/php:8.1-fpm
WORKDIR "/app"

RUN apt-get update && apt-get install -q -y ssmtp mailutils
RUN apt-get -y --no-install-recommends install \
        php8.1-gd \
        php8.1-mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# TLS certificate has to be created manually and added as a secret
# openssl req -new -newkey rsa:4096 -x509 -sha256 -days 365 -nodes -out site.crt -keyout site.key
