default: lint

.PHONY: lint-php
lint-php:
	vendor/bin/phplint --configuration=.phplint.yml --ansi

.PHONY: lint-ecs
lint-ecs:
	vendor/bin/ecs check --output-format=console --verbose --ansi

.PHONY: lint
lint:
	make --no-print-directory lint-php && \
	make --no-print-directory lint-ecs


.PHONY: fix-ecs
fix-ecs:
	vendor/bin/ecs check --output-format=console --fix --verbose --ansi

.PHONY: fix
fix:
	make --no-print-directory fix-ecs


.PHONY: qa-phpmd
qa-phpmd:
	vendor/bin/phpmd src ansi unusedcode,naming,design,controversial,codesize

.PHONY: qa-phpmnd
qa-phpmnd:
	vendor/bin/phpmnd --ansi src

.PHONY: qa-compatibility
qa-compatibility:
	vendor/bin/phpcs --standard=PHPCompatibility --runtime-set testVersion 8.3- src

.PHONY: qa-phpstan
qa-phpstan:
ifeq ($(shell php -v | grep "^PHP" | awk '/ +/{ printf "%s",$$2 }' | awk -F. '//{ printf "%s.%s",$$1,$$2 }'), 8.0)
	vendor/bin/phpstan analyse --configuration=phpstan.8.0.neon --memory-limit=2G --no-progress
else ifeq ($(shell php -v | grep "^PHP" | awk '/ +/{ printf "%s",$$2 }' | awk -F. '//{ printf "%s.%s",$$1,$$2 }'), 8.1)
	vendor/bin/phpstan analyse --configuration=phpstan.8.1.neon --memory-limit=2G --no-progress
else
	vendor/bin/phpstan analyse --configuration=phpstan.neon.dist --memory-limit=2G --no-progress
endif

.PHONY: qa
qa:
	make --no-print-directory qa-phpmd && \
	make --no-print-directory qa-phpmnd && \
	make --no-print-directory qa-compatibility && \
	make --no-print-directory qa-phpstan
