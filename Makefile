.PHONY: run init

APP_ENV ?= dev

run: init

init:
	which docker > /dev/null || (echo "Please install docker binary" && exit 1)
	which direnv > /dev/null || (echo "Please install direnv binary" && exit 1)
	if [ `command -v direnv &> /dev/null` ]; then \
		cp --update=none .envrc.dist .envrc; \
		direnv allow; \
	fi
	docker compose up -d
	./bin-docker/composer install
	rm -fr "tests/Application/var/$(APP_ENV)"
	@make var
	./bin-docker/php ./bin/console --env="$(APP_ENV)" doctrine:database:create --no-interaction --if-not-exists
	./bin-docker/php ./bin/console --env="$(APP_ENV)" doctrine:migrations:migrate --no-interaction
	./bin-docker/php ./bin/console --env="$(APP_ENV)" doctrine:schema:update --force --complete --no-interaction
	./bin-docker/php ./bin/console --env="$(APP_ENV)"  doctrine:migration:sync-metadata-storage
	./bin-docker/php ./bin/console --env="$(APP_ENV)" assets:install
	./bin-docker/yarn --cwd=tests/Application install --pure-lockfile
	GULP_ENV=prod ./bin-docker/yarn --cwd=tests/Application build
	chmod -R 777 tests/Application/var

init-tests:
	which docker > /dev/null || (echo "Please install docker binary" && exit 1)
	which direnv > /dev/null || (echo "Please install direnv binary" && exit 1)
	if [ `command -v direnv &> /dev/null` ]; then \
		cp --update=none .envrc.dist .envrc; \
		direnv allow; \
	fi
	docker compose up -d
	./bin-docker/composer install
	rm -fr tests/Application/var/test
	@make var
	./bin-docker/php ./bin/console --env=test doctrine:database:drop --no-interaction --force --if-exists
	./bin-docker/php ./bin/console --env=test doctrine:database:create --no-interaction --if-not-exists
	./bin-docker/php ./bin/console --env=test doctrine:migrations:migrate --no-interaction
	./bin-docker/php ./bin/console --env=test doctrine:schema:update --force --complete --no-interaction
	./bin-docker/php ./bin/console --env=test doctrine:migration:sync-metadata-storage
	./bin-docker/php ./bin/console --env=test assets:install
	./bin-docker/yarn --cwd=tests/Application install --pure-lockfile
	GULP_ENV=prod ./bin-docker/yarn --cwd=tests/Application build
	chmod -R 777 tests/Application/var

cache:
	./bin-docker/php ./bin/console --env="$(APP_ENV)" cache:clear
	@make var

static: fix static-only

static-only:
	@make ecs
	@make phpstan
	@make composer-lint
	@make symfony-lint
	@make doctrine-lint
	@make say-ok

phpstan:
	./bin-docker/docker-bash bin/phpstan.sh

behat:
	./bin-docker/docker-bash bin/behat.sh

ecs:
	./bin-docker/docker-bash bin/ecs.sh

symfony-lint:
	./bin-docker/docker-bash bin/symfony-lint.sh

composer-lint:
	./bin-docker/composer validate

doctrine-lint:
	./bin-docker/docker-bash bin/doctrine-lint.sh

lint: symfony-lint composer-lint doctrine-lint

yarn-build:
	./bin-docker/yarn install
	./bin-docker/yarn build

make yarn: yarn-build

schema-reset:
	./bin-docker/php ./bin/console --env="$(APP_ENV)" doctrine:database:drop --force --if-exists
	./bin-docker/php ./bin/console --env="$(APP_ENV)" doctrine:database:create --no-interaction
	./bin-docker/php ./bin/console --env="$(APP_ENV)" doctrine:migrations:migrate --no-interaction
	./bin-docker/php ./bin/console --env="$(APP_ENV)" doctrine:schema:update --force --complete --no-interaction
	./bin-docker/php ./bin/console --env="$(APP_ENV)" doctrine:migration:sync-metadata-storage

fix:
	./bin-docker/docker-bash bin/ecs.sh --fix

bare-fixtures:
	@echo "############\nLoading fixtures: $(SPEED_MESSAGE)\n############"
	./bin-docker/php ./bin/console --env="$(APP_ENV)" sylius:fixtures:load --no-interaction

var:
	rm -fr tests/Application/var
	mkdir -p tests/Application/var/log
	touch tests/Application/var/log/test.log
	touch tests/Application/var/log/dev.log
	chmod -R 777 tests/Application/var

fixtures: schema-reset bare-fixtures

static: phpstan ecs lint

tests: static behat

ci: init-tests tests

say-ok:
	@echo "✅ OK ✅"

php-bash:
	./bin-docker/docker-bash

bash: php-bash
