composer.lock: composer.json
	composer install
	touch composer.lock

install:: composer.lock

node_modules/.package-lock.json:
	nvm use 16 && npm ci

node_modules: node_modules/.package-lock.json

node_modules/heroicons: node_modules

assets/icons/outline: node_modules/heroicons
	ln -s ../../node_modules/heroicons/24/outline assets/icons/outline

install:: assets/icons/outline

assets/icons/solid: node_modules/heroicons
	ln -s ../../node_modules/heroicons/24/solid assets/icons/solid

install:: assets/icons/solid

assets/icons/mini: node_modules/heroicons
	ln -s ../../node_modules/heroicons/20/solid assets/icons/mini

install:: assets/icons/mini
