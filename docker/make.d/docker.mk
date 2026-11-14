# GROUP: コンテナの操作
# ========================================
# menu
# ----------------------------------------
TASKS += \
	docker-env:環境変数を表示する \
	docker-mount-check:マウント元を確認する \
	docker-up:コンテナを起動する \
	docker-down:コンテナを停止する \
	docker-login:アプリのコンテナにログインする \
	docker-reset:MySQLを初期化する
# ========================================
# command
# ----------------------------------------
.PHONY: docker-env
docker-env:
	$(call print_headline,${@})
	@echo "COMPOSE_PROJECT_NAME  : $(COMPOSE_PROJECT_NAME)"
	@echo "__WSL_COMPOSE_PROJECT_DIR : $(__WSL_COMPOSE_PROJECT_DIR)"

# mount 元が、このリポジトリと一致するかを確認する(core の確認は、core-status で行う)。
.PHONY: docker-mount-check
docker-mount-check:
	$(call print_headline,${@})
	@echo "COMPOSE_PROJECT_NAME        : $(COMPOSE_PROJECT_NAME)"
	@echo "__WSL_COMPOSE_PROJECT_DIR   : $(__WSL_COMPOSE_PROJECT_DIR)"
	@echo "このリポジトリのディレクトリ : $(notdir $(ROOT_DIR))"
	@if [ "$(__WSL_COMPOSE_PROJECT_DIR)" = "$(notdir $(ROOT_DIR))" ]; then \
		echo "[OK] mount 元が、このリポジトリと一致しています"; \
	else \
		echo "[NG] mount 元(/var/www/$(__WSL_COMPOSE_PROJECT_DIR))が、このリポジトリと一致しません"; exit 1; \
	fi
	@running=$$(docker compose -f docker-compose.yml ps --status running -q $(NAME) 2>/dev/null); \
	if [ -z "$$running" ]; then \
		echo "[WARN] コンテナが起動していません(docker-up を実行してください)。コンテナ側の確認を飛ばします"; \
	elif docker compose -f docker-compose.yml exec -T $(NAME) test -f submodules/laravel-ddd-core/composer.json; then \
		echo "[OK] コンテナから core が見えます"; \
	else \
		echo "[NG] コンテナから core が見えません(mount 元を確認してください)"; exit 1; \
	fi

.PHONY: docker-up
docker-up:
	$(call print_headline,${@})
	@docker compose -f docker-compose.yml up -d

.PHONY: docker-down
docker-down:
	$(call print_headline,${@})
	@docker compose -f docker-compose.yml down

.PHONY: docker-login
docker-login:
	$(call print_headline,${@})
	@docker-compose exec $(NAME) bash --login

SERVICES ?= mysql_master mysql_slave
.PHONY: docker-reset
docker-reset:
	$(call print_headline,${@})
	@docker-compose -f docker-compose.yml down -v $(SERVICES)
	@docker-compose -f docker-compose.yml up -d --build $(SERVICES)
