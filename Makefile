it: cs test

composer:
	composer validate
	composer install

coverage: composer
	vendor/bin/phpunit --configuration phpunit.xml --coverage-text --columns max

cs: composer
	vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --diff

test: composer
	vendor/bin/phpunit --configuration phpunit.xml --columns max
