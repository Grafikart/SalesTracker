.PHONY: seed deploy install dev help

server := "jonathan-boyer"
domain := "tracker.roundnet-montpellier.fr"

.PHONY: help
help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

dev: ## Start the development server
	parallel -j 2 --line-buffer ::: "php artisan serve" "bun run dev"

seed: ## Fill the database
	php artisan migrate:fresh --seed

deploy: ## Deploy the site remotely
	bun run build
	rsync -avH ./public/build/ -e ssh $(server):~/sites/$(domain)/public/build/
	ssh -A $(server) 'cd ~/sites/$(domain) && git pull origin main && make install'

install: ## Installe les différentes dépendances
	/opt/php8.4/bin/composer install --no-dev --optimize-autoloader
	/opt/php8.4/bin/php artisan cache:clear

vendor/autoload.php: composer.lock
	composer install --no-dev --optimize-autoloader
	touch vendor/autoload.php
