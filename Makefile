# Parameters
SHELL         = sh
HTTP_PORT     = 8000

# Executables
EXEC_PHP      = php
COMPOSER      = composer
GIT           = git

# Alias
SYMFONY       = $(EXEC_PHP) bin/console

# Executables: vendors
PHPUNIT       = ./vendor/bin/phpunit
PHPSTAN       = ./vendor/bin/phpstan
PINT  				= ./vendor/bin/pint

# Executables: local only
SYMFONY_BIN   = symfony

# Misc
.DEFAULT_GOAL = help
.PHONY        : # Not needed here, but you can put your all your targets to be sure
                # there is no name conflict between your files and your targets.

help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Composer 🧙‍♂️ ————————————————————————————————————————————————————————————
install: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --no-progress --prefer-dist --optimize-autoloader

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands
	@$(SYMFONY)

cc: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	@$(SYMFONY) c:c

warmup: ## Warmup the cache
	@$(SYMFONY) cache:warmup

purge: ## Purge cache and logs
	@rm -rf var/cache/* var/logs/*

## —— Symfony binary 💻 ————————————————————————————————————————————————————————
cert-install: ## Install the local HTTPS certificates
	@$(SYMFONY_BIN) server:ca:install

serve: ## Serve the application with HTTPS support (add "--no-tls" to disable https)
	@$(SYMFONY_BIN) serve --daemon --port=$(HTTP_PORT)

unserve: ## Stop the webserver
	@$(SYMFONY_BIN) server:stop

## —— Project ———————————————————————————————————————————————————————————————
start: serve ## Start the project

stop: unserve ## Stop the project

commands: ## Display all commands in the project namespace
	@$(SYMFONY) list $(PROJECT)

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: ## Run tests with optionnal suite and filter
	@$(eval testsuite ?= 'all')
	@$(eval filter ?= '.')
	@$(PHPUNIT) --testsuite=$(testsuite) --filter=$(filter) --stop-on-failure

test-all: ## Run all tests
	@$(PHPUNIT) --stop-on-failure

## —— Coding standards ✨ ——————————————————————————————————————————————————————
cs: lint-php ## Run all coding standards checks

static-analysis: stan ## Run the static analysis (PHPStan)

stan: ## Run PHPStan
	@$(PHPSTAN) analyse --memory-limit 1G

lint-php: ## Lint files with pint
	@$(PINT) --test

fix-php: ## Fix files with pint
	@$(PINT)

## —— ImportMaps —————————————————————————————————————————————————————
dev: ## Rebuild assets for the dev env
	@$(SYMFONY) tailwind:build

watch: ## Watch files and build assets when needed for the dev env
	@$(SYMFONY) tailwind:build --watch

production: ## Build assets for production
	@$(SYMFONY) tailwind:build --minify
	@$(SYMFONY) asset-map:compile
