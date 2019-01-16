FROM ubuntu:18.04 AS symfony_docker
MAINTAINER François PASINI <francois.pasini@gmail.com>

ENV DEBIAN_FRONTEND=noninteractive
ENV WORKDIR /var/www/html
ENV PHP_VERSION 7.1
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update -qq \
    && apt-get install -qq software-properties-common apache2 vim curl git locales unzip debconf-utils supervisor cron

RUN add-apt-repository ppa:ondrej/php \
    && apt-get install -qq \
    php${PHP_VERSION} \php${PHP_VERSION}-apc php${PHP_VERSION}-mysql php${PHP_VERSION}-curl php${PHP_VERSION}-cli php${PHP_VERSION}-intl php${PHP_VERSION}-mbstring php${PHP_VERSION}-gd php${PHP_VERSION}-redis php${PHP_VERSION}-xml php${PHP_VERSION}-zip libapache2-mod-php${PHP_VERSION}

RUN apt-get install -qq build-essential -V \
    && locale-gen 'fr_FR.UTF-8' 'en_US.UTF-8' \
    && a2enmod rewrite

RUN curl -Ss https://getcomposer.org/installer | php \
    && mv /composer.phar /usr/local/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - \
    && apt-get install -qq nodejs

#RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
#    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
RUN apt-get install -qq yarn

# set the working directory
WORKDIR ${WORKDIR}

# Apache config
COPY apache/docker.apache.conf /etc/apache2/sites-available/000-default.conf
RUN sed -i -e "s/^memory_limit = .*$/memory_limit = -1/g" /etc/php/*/*/php.ini
#RUN sed -i -e "s/^post_max_size = .*$/post_max_size = 125M/g" /etc/php/*/apache2/php.ini
#RUN sed -i -e "s/^upload_max_filesize = .*$/upload_max_filesize = 100M/g" /etc/php/*/apache2/php.ini
RUN sed -i -e "s/^max_execution_time = .*$/max_execution_time = 0/g" /etc/php/*/*/php.ini

RUN apt-get update --fix-missing \
    && apt-get upgrade -qq


COPY . $WORKDIR

RUN mkdir -p var/cache var/logs var/sessions \
#    && composer install --prefer-dist --no-dev --no-scripts --no-progress --no-suggest --classmap-authoritative --no-interaction \
#    && composer init-front-local --no-interaction \
    && chown -R www-data:www-data var

##
# RUN.
##

RUN /usr/sbin/apache2ctl stop

# uncomment to open port
EXPOSE 80

ENTRYPOINT ["/usr/sbin/apachectl", "-DFOREGROUND"]
