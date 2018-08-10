.DEFAULT_GOAL := help
.PHONY: help
.SILENT:

GREEN  := $(shell tput -Txterm setaf 2)
WHITE  := $(shell tput -Txterm setaf 7)
YELLOW := $(shell tput -Txterm setaf 3)
RESET  := $(shell tput -Txterm sgr0)

test: lint phpcs phpunit

install:
	composer install --prefer-dist

## Run PHP unit tests
phpunit:
	@echo "${GREEN}Unit tests${RESET}"
	vendor/bin/phpunit

## Run PHP code sniffer
phpcs:
	@echo "${GREEN}PHP Code Sniffer${RESET}"
	vendor/bin/phpcs -p --standard=psr2 --colors src/

## PHP Parallel Lint
lint:
	@echo "${GREEN}PHP Parallel Lint${RESET}"
	vendor/bin/parallel-lint src/ tests/

## Test Coverage HTML
coverage:
	@echo "${GREEN}Tests with coverage${RESET}"
	vendor/bin/phpunit --coverage-html /tmp/coverage

## Prints this help
help:
	@echo "\nUsage: make ${YELLOW}<target>${RESET}\n\nThe following targets are available:\n";
	@awk -v skip=1 \
		'/^##/ { sub(/^[#[:blank:]]*/, "", $$0); doc_h=$$0; doc=""; skip=0; next } \
		 skip  { next } \
		 /^#/  { doc=doc "\n" substr($$0, 2); next } \
		 /:/   { sub(/:.*/, "", $$0); printf "\033[34m%-30s\033[0m\033[1m%s\033[0m %s\n", $$0, doc_h, doc; skip=1 }' \
		$(MAKEFILE_LIST)