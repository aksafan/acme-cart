build: docker-build
up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-all docker-build docker-up composer-install
check: phpcs phpstan test-unit

docker-build:
	docker compose build --pull --no-cache

docker-up:
	docker-compose up -d
	
docker-down:
	docker-compose down --remove-orphans

docker-down-all:
	docker-compose down -v --remove-orphans

composer-install:
	docker-compose run --rm acme-cart-php-cli composer install

sh:
	docker-compose exec $(c) sh

logs:
	docker-compose logs --tail=0 --follow

test:
	docker-compose run --rm acme-cart-php-cli php vendor/bin/phpunit

test-coverage:
	docker-compose run -e XDEBUG_MODE=coverage --rm acme-cart-php-cli php vendor/bin/phpunit --coverage-clover var/clover.xml --coverage-html var/coverage --coverage-filter=src/

test-unit:
	docker-compose run --rm acme-cart-php-cli php vendor/bin/phpunit --testsuite=unit

test-unit-coverage:
	docker-compose run -e XDEBUG_MODE=coverage --rm acme-cart-php-cli php vendor/bin/phpunit --testsuite=unit --coverage-clover var/clover.xml --coverage-html var/coverage --coverage-filter=src/

phpstan:
	docker-compose run --rm acme-cart-php-cli php vendor/bin/phpstan analyse --level max --configuration phpstan.neon src/

phpstan-baseline:
	docker-compose run --rm acme-cart-php-cli php vendor/bin/phpstan analyse --level max --configuration phpstan.neon src/ --generate-baseline

phpcs:
	docker-compose run --rm acme-cart-php-cli php vendor/bin/phpcs

phpcs-fix:
	docker-compose run --rm acme-cart-php-cli php vendor/bin/phpcbf