#Makefile

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src

autoload:
	composer dump-autoload

install:
	composer install

test:
	./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/