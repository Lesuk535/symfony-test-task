docker-up:
	docker-compose up -d

docker-up-build:
	docker-compose up --build -d

docker-restart:
	docker-compose down --remove-orphans && docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

composer-install:
	docker container exec -it ecommerce-php-cli composer install

composer-update:
	docker container exec -it ecommerce-php-cli composer update

composer-require-dev:
	docker container exec -it ecommerce-php-cli composer require --dev ${p}

composer-command:
	docker container exec -it ecommerce-php-cli composer ${c}

yarn-install:
	docker-compose exec node yarn install

yarn-add:
	docker-compose exec node yarn add ${p}

yarn-run-dev:
	docker-compose exec node yarn run dev

composer-require:
	docker container exec -it ecommerce-php-cli composer require ${p}

assets-install:
	docker-compose exec node yarn install

chmod:
	sudo chmod -R 777 ${p}

