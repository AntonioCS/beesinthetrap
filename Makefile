PHP_CONTAINER = php-fpm

.DEFAULT_GOAL := help

start: ## Initiate docker
	docker-compose up -d

bash: ## SSH into php container
	docker-compose exec $(PHP_CONTAINER) bash

install: ## Run composer install
	docker-compose exec $(PHP_CONTAINER) composer install
	
play: ## Play the game (make sure you run start and install first)
	docker-compose exec $(PHP_CONTAINER) php main.php

PHONY: help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
	
	
