FROM phpdockerio/php:8.1-fpm
WORKDIR "/app"

RUN apt-get update && apt-get install -q -y ssmtp mailutils \
    && echo "hostname=localhost.localdomain" > /etc/ssmtp/ssmtp.conf \
    && echo "root=jukkacamagru@outlook.com" >> /etc/ssmtp/ssmtp.conf \
    # Mailhog configuration
    #&& echo "mailhub=mailhog:1025" >> /etc/ssmtp/ssmtp.conf
    && echo "root=jukka.ylimaula@gmail.com" >> /etc/ssmtp/ssmtp.conf \
    && echo "mailhub=smtp.office365.com:587" >> /etc/ssmtp/ssmtp.conf \
    && echo "AuthUser=jukkacamagru@outlook.com" >> /etc/ssmtp/ssmtp.conf \
    && echo "AuthPass=Camagru123!" >> /etc/ssmtp/ssmtp.conf \
    && echo "UseSTARTTLS=YES" >> /etc/ssmtp/ssmtp.conf \
    && echo "TLS_CA_File=/root/certs/MyCertificate.crt" >> /etc/ssmtp/ssmtp.conf \
    && echo "RewriteDomain=localhost" >> /etc/ssmtp/ssmtp.conf \
    && echo "Hostname=localhost" >> /etc/ssmtp/ssmtp.conf \
    && echo "FromLineOverride=YES" >> /etc/ssmtp/ssmtp.conf
RUN apt-get -y --no-install-recommends install \
        php8.1-gd \
        php8.1-mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# TLS certificate has to be created manually inside the container
#mkdir /root/certs && openssl req -new -newkey rsa:4096 -x509 -sha256 -days 365 -nodes -out /root/certs/MyCertificate.crt -keyout /root/certs/MyKey.key