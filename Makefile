composer:
	composer valid

twig:
	php bin/console lint:twig src/Shared/Infrastructure/Resources/templates
	vendor/bin/twigcs src/Shared/Infrastructure/Resources/templates

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

analyse:
	make composer
	make twig
	make phpcpd
	make phpmd
	make phpinsights
	make phpstan

.PHONY: tests
tests:
	vendor/bin/behat
	php bin/phpunit

fixtures:
	php bin/console doctrine:fixtures:load -n --env=$(env)

database:
	php bin/console doctrine:database:drop --if-exists --force --env=$(env)
	php bin/console doctrine:database:create --env=$(env)
	php bin/console doctrine:schema:update --force --env=$(env)

prepare:
	make database env=$(env)
	make fixtures env=$(env)

install:
	cp .env.dist .env.$(env).local
	sed -i -e 's/DATABASE_USER/$(db_user)/' .env.$(env).local
	sed -i -e 's/DATABASE_PASSWORD/$(db_password)/' .env.$(env).local
	sed -i -e 's/ENV/$(env)/' .env.$(env).local
	composer install
	make prepare env=$(env)

profile:
	make prepare env=$(env)
	blackfire-player run .blackfire.yaml --endpoint=$(endpoint) --blackfire-env=rse
