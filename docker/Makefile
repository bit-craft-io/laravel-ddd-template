SHELL := /bin/bash
-include .env
export
XDEBUG_MODE=off
MAKEFLAGS += --no-print-directory
.DEFAULT_GOAL := menu

ifneq ($(origin NAME),command line)
NAME := app
endif

DOCKER_EXEC := docker-compose exec -u 1000:1000 -w /var/www/source -it $(NAME)

# ========================================
# include
# メインメニューのグループは、ここの include から作られる(_ で始まるものは除く)。
# グループの説明は各 .mk の `# GROUP:`、タスクと説明は `TASKS +=` に書く。
# ----------------------------------------
include make.d/_common.mk
include make.d/docker.mk
include make.d/app.mk
include make.d/core.mk
include make.d/php.mk
include make.d/test.mk
include make.d/composer.mk
include make.d/artisan.mk
include make.d/migrate.mk
include make.d/job.mk

# ========================================
# menu
# ----------------------------------------
.PHONY: menu
menu:
	@bash make.d/menu.sh

.DEFAULT:
	@echo "[WARN] target '$@' unknown"
