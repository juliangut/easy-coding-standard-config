default: lint

.PHONY: lint-php
lint-php:
	vendor/bin/phplint --configuration=.phplint.yml --ansi

.PHONY: lint-ecs
lint-ecs:
	vendor/bin/ecs check --verbose --ansi

.PHONY: lint
lint:
	make --no-print-directory lint-php && \
	make --no-print-directory lint-ecs


.PHONY: fix-ecs
fix-ecs:
	vendor/bin/ecs check --fix --verbose --ansi

.PHONY: fix
fix:
	make --no-print-directory fix-ecs


.PHONY: qa-phpcpd
qa-phpcpd:
	vendor/bin/phpcpd src

.PHONY: qa-phpmd
qa-phpmd:
	vendor/bin/phpmd src ansi unusedcode,naming,design,controversial,codesize

.PHONY: qa-phpmnd
qa-phpmnd:
	vendor/bin/phpmnd --ansi src

.PHONY: qa-compatibility
qa-compatibility:
	vendor/bin/phpcs --standard=PHPCompatibility --runtime-set testVersion 8.2- src

.PHONY: qa-phpstan
qa-phpstan:
	vendor/bin/phpstan analyse --memory-limit=2G --no-progress

.PHONY: qa
qa:
	make --no-print-directory qa-phpcpd && \
	make --no-print-directory qa-phpmd && \
	make --no-print-directory qa-phpmnd && \
	make --no-print-directory qa-compatibility && \
	make --no-print-directory qa-phpstan
