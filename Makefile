UID := $(shell id -u)
GID := $(shell id -g)

# 1回だけ
build:
	docker compose build --no-cache --force-rm

bash:
	docker compose run --rm php bash

phpstan:
	docker compose run --rm php vendor/bin/phpstan analyse

# Composer
composer-install:
	docker compose run --rm php composer install --no-interaction --prefer-dist
composer-update:
	docker compose run --rm php composer update --no-interaction
composer-dump:
	docker compose run --rm php composer dump-autoload -o

# Artisan（引数は CMD=... で渡す）
artisan:
	docker compose run --rm php php artisan $(CMD)

# Tinker（対話型）
tinker:
	docker compose run --rm -it php php artisan tinker

# サーバ（必要なら）
serve:
	docker compose run --rm -p 8000:8000 php php artisan serve --host 0.0.0.0 --port 8000
