composer:
	composer validate
	composer install

coverage: composer
	vendor/bin/phpunit --configuration phpunit.xml --coverage-text --columns max

cs: composer
	vendor/bin/php-cs-fixer fix --config-file=.php_cs --verbose --diff

it: cs test

test: composer
	vendor/bin/phpunit --configuration phpunit.xml --columns max
