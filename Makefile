.PHONE: twig phpmd phpinsights phpcpd phpstan

twig:
	php bin/console lint:twig templates
	vendor/bin/twigcs templates

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