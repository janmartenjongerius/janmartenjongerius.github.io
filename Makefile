install::

build:: install

clean::
	rm -rf vendor
	rm -rf var/cache/*
	rm -f var/log/*.log

vendor/autoload.php: composer.lock composer.json
	composer install
	touch vendor/autoload.php

composer.lock: composer.json
	composer update
	touch composer.lock

install:: vendor/autoload.php

node_modules/.package-lock.json:
	npm ci

node_modules: node_modules/.package-lock.json

clean::
	rm -rf node_modules/

node_modules/heroicons: node_modules

assets/icons/outline: node_modules/heroicons
	ln -s ../../node_modules/heroicons/24/outline assets/icons/outline

install:: assets/icons/outline

clean::
	rm -f assets/icons/outline

assets/icons/mini: node_modules/heroicons
	ln -s ../../node_modules/heroicons/20/solid assets/icons/mini

install:: assets/icons/mini

clean::
	rm -f assets/icons/mini

public/build/manifest.json: node_modules/.package-lock.json
	mkdir -p public/build
	npm run build

build:: public/build/manifest.json

clean::
	rm -rf public/build


dist/build/manifest.json: public/build/manifest.json
	mkdir -p dist
	cp -r public/build dist/

var/data.db: vendor/autoload.php
	php bin/console doctrine:schema:create --no-interaction --quiet
	php bin/console doctrine:schema:update --no-interaction --force --complete
	php bin/console doctrine:fixtures:load --no-interaction

clean::
	rm -f var/data.db

dist/index.html: vendor/autoload.php var/data.db
	mkdir -p dist
	php bin/console app:build > dist/index.html.tmp
	mv -f dist/index.html.tmp dist/index.html

build:: dist/index.html dist/build/manifest.json

clean::
	rm -rf dist