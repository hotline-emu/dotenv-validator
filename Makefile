help:
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

install: ## Installs the composer dependencies locally
	composer install

lint: ## Run the linter locally
	vendor/bin/phpcs

phpunit: ## Run the unit tests
	vendor/bin/phpunit

phing: ## Run the phing build locally
	vendor/bin/phing -buildfile phing.xml

build: install phing ## Run the build locally

lint-dockerfile: ## Lint the dockerfile
	docker run --rm -i hadolint/hadolint hadolint \
    	- < Dockerfile

build-dockerfile: lint-dockerfile ## Build the dockerfile
	docker build .
