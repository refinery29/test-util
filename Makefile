.PHONY: composer coverage cs it test

it: cs test

composer:
	rm -rf composer.lock
	composer self-update
	composer validate
	composer update

coverage: composer
	vendor/bin/phpunit --configuration phpunit.xml --coverage-text

cs: composer
	vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --diff

test: composer
	vendor/bin/phpunit --configuration phpunit.xml
	composer update --prefer-lowest
	vendor/bin/phpunit --configuration phpunit.xml
