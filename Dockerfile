FROM mrjoops/simplon-cpro6-php

ADD . .

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ports.conf /etc/apache2/ports.conf

ENV APP_ENV prod
ENV PORT 80

RUN composer install -no --no-dev
