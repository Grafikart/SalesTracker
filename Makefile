.PHONY: seed deploy

server := "jonathan-boyer"
domain := "tracker.roundnet-montpellier.fr"

seed:
	php artisan migrate:fresh --seed

deploy:
	bun run build
	rsync -avH ./public/build/ -e ssh $(server):~/sites/$(domain)/public/build/
	ssh -A $(server) 'cd ~/sites/$(domain) && git pull origin main && make install'

install: vendor/autoload.php ## Installe les différentes dépendances
	/opt/php8.4/bin/composer install --no-dev --optimize-autoloader
	/opt/php8.4/bin/php artisan cache:clear

vendor/autoload.php: composer.lock
	composer install
	touch vendor/autoload.php
