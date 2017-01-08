.PHONY: composer coverage cs it test

it: cs test

composer:
	composer self-update
	composer validate
	composer update --prefer-dist

coverage: composer
	vendor/bin/phpunit --configuration phpunit.xml --coverage-text

cs: composer
	vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --diff

test: composer
	vendor/bin/phpunit --configuration phpunit.xml
	composer update --prefer-dist --prefer-lowest
	vendor/bin/phpunit --configuration phpunit.xml
