PHP_CS_FIXER=./tools/php-cs-fixer/vendor/bin/php-cs-fixer
FIXER_OPTIONS=fix --rules=@PSR12
PHPSTAN=./tools/phpstan/vendor/bin/phpstan


## Help
.DEFAULT_GOAL := help
help:
	@awk '/^[a-zA-Z\-_]+:/ {print "  -", substr($$1, 1, length($$1)-1)}' $(MAKEFILE_LIST)

phpcs:
	$(PHP_CS_FIXER) $(FIXER_OPTIONS)

phpcs-check:
	$(PHP_CS_FIXER) fix --dry-run --diff $(FIXER_OPTIONS)

phpstan:
	$(PHPSTAN) --level=9 analyse src
