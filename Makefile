.PHONY: check
check: cs md security stan

.PHONY: cs
cs: vendor
	./vendor/bin/php-cs-fixer fix --allow-risky=yes --dry-run --using-cache=no -vvv src/

.PHONY: fix
fix: vendor
	./vendor/bin/php-cs-fixer fix --allow-risky=yes -vvv src/

.PHONY: install
install: vendor
	./bin/console doctrine:database:create --if-not-exists
	./bin/console doctrine:migrations:migrate --no-interaction

.PHONY: md
md: vendor
	./vendor/bin/phpmd src/ text cleancode,codesize,controversial,design,naming,unusedcode

.PHONY: security
security: vendor
	./bin/console security:check

.PHONY: stan
stan: vendor
	./vendor/bin/phpstan analyse -l 7 src/

vendor:
	composer install
