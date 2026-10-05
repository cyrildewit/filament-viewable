# Well documented Makefiles
DEFAULT_GOAL := help

# None of these targets produce a file. `build` in particular would otherwise
# clash with the build/ directory and never run.
.PHONY: help build install lint rector ready test test-arch test-unit test-feature test-lint test-types test-type-coverage test-coverage workbench serve
help:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z0-9_-]+:.*?##/ { printf "  \033[36m%-40s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

build: ## Build all docker images. Specify the command e.g. via make build ARGS="--build-arg PHP=8.5"
	docker compose build $(ARGS)

##@ [Application]
install: ## Install the composer dependencies
	docker compose run --rm composer install

lint: ## Fix the code style
	docker compose run --rm composer lint

rector: ## Run Rector
	docker compose run --rm composer rector

ready: ## Fix with Rector and the linter, then run the static analysis and the tests
	XDEBUG_MODE=off docker compose run --rm composer ready

test: ## Run the tests in parallel (SQLite in memory)
	XDEBUG_MODE=off docker compose run --rm composer test

test-arch: ## Run the architecture tests
	docker compose run --rm composer test:arch

test-unit: ## Run the unit tests (no Laravel application is booted)
	docker compose run --rm composer test:unit

test-feature: ## Run the feature tests (the workbench panel, booted through Testbench)
	docker compose run --rm composer test:feature

test-lint: ## Check the code style without fixing it
	docker compose run --rm composer test:lint

test-types: ## Run the static analysis
	docker compose run --rm composer test:types

test-type-coverage: ## Run the tests with type coverage and fail below 100%
	docker compose run --rm composer test:type-coverage

test-coverage: ## Run the tests with coverage and fail below 100% (writes build/coverage.xml)
	docker compose run --rm composer test:coverage

##@ [Workbench]
# A Filament panel with the plugin registered, seeded posts and views. Sign in
# at http://localhost:8000/admin as admin@example.com with `password`.
# SERVE_PORT picks another port on the host.

workbench: ## Rebuild the workbench database from scratch and publish Filament's assets
	XDEBUG_MODE=off docker compose run --rm composer workbench:build

serve: workbench ## Serve the workbench on http://localhost:8000/admin
	XDEBUG_MODE=off docker compose run --rm --service-ports php vendor/bin/testbench serve --host=0.0.0.0 --port=8000
