.PHONE: twig

twig:
	php bin/console lint:twig templates
	vendor/bin/twigcs templates
