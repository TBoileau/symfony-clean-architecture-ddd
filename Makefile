.PHONE: twig phpmd phpinsights phpcpd

twig:
	php bin/console lint:twig templates
	vendor/bin/twigcs templates

phpmd:
	vendor/bin/phpmd src/ text .phpmd.xml

phpinsights:
	vendor/bin/phpinsights --no-interaction

phpcpd:
	vendor/bin/phpcpd src/

fix:
	vendor/bin/php-cs-fixer fix