# GROUP: マイグレーションの操作
# ========================================
# menu
# ----------------------------------------
TASKS += \
	migrate-all:全DBをマイグレーションする \
	migrate-app:app_dbをマイグレーションする \
	migrate-test:test_dbをマイグレーションする \
	migrate-log:log_dbをマイグレーションする \
	migrate-seeder-dev:開発用のシーダーを実行する \
	migrate-reset-all:全DBをリセットする \
	migrate-reset-app:app_dbをリセットする \
	migrate-reset-test:test_dbをリセットする \
	migrate-reset-log:log_dbをリセットする \
	migrate-fresh-all:全DBを作り直す \
	migrate-fresh:指定DBを作り直す（選択あり）
# ========================================
# command
# ----------------------------------------
.PHONY: migrate-all
migrate-all:
	$(call print_headline,${@})
	@$(MAKE) migrate-app
	@$(MAKE) migrate-log
	@$(MAKE) migrate-test

.PHONY: migrate-app
migrate-app:
	$(call print_headline,${@})
	@$(MAKE) migrate DB_NAME=app_db DB_PATH=database/migrations DB_CORE=1

.PHONY: migrate-test
migrate-test:
	$(call print_headline,${@})
	@$(MAKE) migrate DB_NAME=test_db DB_PATH=database/migrations DB_CORE=1

.PHONY: migrate-log
migrate-log:
	$(call print_headline,${@})
	@$(MAKE) migrate DB_NAME=log_db DB_PATH=database/migrations/log

# 内部用(DB_NAME と DB_PATH を指定して呼ぶ。DB_CORE=1 なら、core のマイグレーションも対象にする)
.PHONY: migrate
migrate:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) env DB_DATABASE=$(DB_NAME) php artisan migrate --path=$(DB_PATH) $(if $(DB_CORE),--path=$(CORE_MIGRATION_PATH))

# ========================================
# seeder
# ----------------------------------------
.PHONY: migrate-seeder-dev
migrate-seeder-dev:
	$(call print_headline,${@})
	@$(MAKE) migrate-seeder DB_NAME=app_db SD_NAME=DevMaster
	@$(MAKE) migrate-seeder DB_NAME=app_db SD_NAME=DevUser
	@$(MAKE) migrate-seeder DB_NAME=log_db SD_NAME=DevLog

# 内部用(DB_NAME と SD_NAME を指定して呼ぶ)
.PHONY: migrate-seeder
migrate-seeder:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) env DB_DATABASE=$(DB_NAME) php artisan db:seed $(SD_NAME)

# ========================================
# migrate:reset
# ----------------------------------------
.PHONY: migrate-reset-all
migrate-reset-all:
	$(call print_headline,${@})
	@$(MAKE) migrate-reset-app
	@$(MAKE) migrate-reset-log
	@$(MAKE) migrate-reset-test

.PHONY: migrate-reset-app
migrate-reset-app:
	$(call print_headline,${@})
	@$(MAKE) migrate-reset DB_NAME=app_db DB_PATH=database/migrations DB_CORE=1

.PHONY: migrate-reset-test
migrate-reset-test:
	$(call print_headline,${@})
	@$(MAKE) migrate-reset DB_NAME=test_db DB_PATH=database/migrations DB_CORE=1

.PHONY: migrate-reset-log
migrate-reset-log:
	$(call print_headline,${@})
	@$(MAKE) migrate-reset DB_NAME=log_db DB_PATH=database/migrations/log

# 内部用(DB_NAME と DB_PATH を指定して呼ぶ)
.PHONY: migrate-reset
migrate-reset:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) env DB_DATABASE=$(DB_NAME) php artisan migrate:reset --path=$(DB_PATH) $(if $(DB_CORE),--path=$(CORE_MIGRATION_PATH))

# ========================================
# migrate-fresh
# ----------------------------------------
.PHONY: migrate-fresh-all
migrate-fresh-all:
	$(call print_headline,${@})
	@$(MAKE) migrate-fresh DB_NAME=app_db
	@$(MAKE) migrate-fresh DB_NAME=test_db
	@$(MAKE) migrate-fresh DB_NAME=log_db

# DB は DB_NAME で指定する。未指定なら、番号で選ぶ。
.PHONY: migrate-fresh
migrate-fresh:
	@db="$(DB_NAME)"; \
	[ -n "$$db" ] || db=$$(bash make.d/choose.sh "DB名" app_db test_db log_db) || exit 1; \
	bash make.d/header.sh migrate-fresh "DB_NAME=$$db"; \
	extra=""; [ "$$db" = "log_db" ] || extra="--path=database/migrations --path=$(CORE_MIGRATION_PATH)"; \
	$(DOCKER_EXEC) env DB_DATABASE=$$db php artisan migrate:fresh $$extra
