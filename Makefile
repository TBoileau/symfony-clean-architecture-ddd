composer:
	composer valid

twig:
	php bin/console lint:twig src/Shared/Infrastructure/Resources/templates src/Security/Infrastructure/Resources/templates
	vendor/bin/twigcs src/Shared/Infrastructure/Resources/templates src/Security/Infrastructure/Resources/templates

phpmd:
	vendor/bin/phpmd src/ text .phpmd.xml

phpinsights:
	vendor/bin/phpinsights --no-interaction

phpcpd:
	vendor/bin/phpcpd src/

phpstan:
	php vendor/bin/phpstan analyse -c phpstan.neon src --no-progress

fix:
	vendor/bin/php-cs-fixer fix

container:
	php bin/console lint:container

analyse:
	make composer
	make twig
	make container
	make phpcpd
	make phpmd
	make phpinsights
	make phpstan

.PHONY: tests
tests:
	vendor/bin/behat
	php bin/phpunit

fixtures:
	php bin/console inmemory:fixtures:load --env=$(env)

database:
	php bin/console inmemory:database:create --env=$(env)

prepare:
	make database env=$(env)
	make fixtures env=$(env)

install:
	cp .env.dist .env.$(env).local
	sed -i -e 's/ENV/$(env)/' .env.$(env).local
	composer install
	make prepare env=$(env)

profile:
	blackfire-player run .blackfire.yaml --endpoint=$(endpoint) --blackfire-env=rse
