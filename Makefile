.DEFAULT_GOAL := help
.PHONY: help
compose_file_path = ./docker-compose.yml
dc = docker-compose --file $(compose_file_path) 
service_php = php-fpm
service_node = node

bash-php: ## Open bash prompt to php docker container
	$(dc) exec $(service_php) bash

start: ## Start containers
	$(dc) up -d

start-no-d: ## Start containers not in detach mode
	$(dc) up

stop: ## Stop containers
	$(dc) stop

composer-install: ## Run composer install
	$(dc) exec $(service_php) composer install

run-tests: ## Run all unit tests
	$(dc) exec $(service_php) vendor/bin/phpunit

clear-cache: ## Clear cache using symfony commands
	$(dc) exec $(service_php) bin/console cache:clear

remove-cache: ## Remove cache by using rm -rf (symfony)
	$(dc) exec $(service_php) rm -rf ./var/cache/*

tail-dev-log: ## Tail the dev log
	$(dc) exec $(service_php) tail -f ./var/logs/dev.log	

make-vendor-writable: ## Make the vendor folder writable (useful for debugging)
	$(dc) exec $(service_php) chmod 777 -R vendor/

docker-show-logs: ## Show container logs
	$(dc) logs -f -t
	
docker-list-containers: ## List containers
	$(dc) ps

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
