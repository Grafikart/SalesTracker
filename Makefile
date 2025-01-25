.PHONY: seed deploy

server := "jonathan-boyer"
domain := "tracker.roundnet-montpellier.fr"

seed:
	php artisan migrate:fresh --seed

deploy:
	bun run build
	rsync -avH ./database/database.sqlite -e ssh $(server):~/sites/$(domain)/database/database.sqlite
	ssh -A $(server) 'cd ~/sites/$(domain) && git pull origin main && make install'

install: vendor/autoload.php public/assets/.vite/manifest.json ## Installe les différentes dépendances
	composer install --no-dev --optimize-autoloader
	php artisan cache:clear

vendor/autoload.php: composer.lock
	composer install
	touch vendor/autoload.php
