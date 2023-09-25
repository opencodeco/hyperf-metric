build:
	@docker-compose build

up:
	@docker-compose up -d

down:
	@docker-compose down

test:
	@docker-compose run --rm composer test

ssh:
	@docker exec -it hyperf-metric_app sh

update:
	@docker-compose run --rm composer update