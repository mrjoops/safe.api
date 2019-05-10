release: ./bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
web: $(composer config bin-dir)/heroku-php-apache2 public/
