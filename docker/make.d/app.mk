# GROUP: アプリの操作
# ========================================
# menu
# ----------------------------------------
TASKS += \
	app-init:アプリを初期設定する \
	app-env-setup:.envを作成する \
	app-clean:キャッシュを削除する \
	app-reset:データベースを初期化する \
	app-route:ルートを表示する \
	app-autoload:オートロードを再生成する \
	app-legacy-check:旧記述の残りを確認する
# ========================================
# command
# ----------------------------------------
.PHONY: app-init
app-init:
	$(call print_headline,${@})
	@$(MAKE) app-env-setup
	@$(MAKE) composer-install
	@read -p "DB を初期化します(migrate:fresh)。実行しますか? [y/N]: " ans; \
	if [ "$$ans" = "y" ]; then $(MAKE) app-reset; else echo "app-reset をスキップしました"; fi
	@$(MAKE) app-clean

.PHONY: app-env-setup
app-env-setup:
	$(call print_headline,${@})
	@if [ ! -f .env ]; then \
		cp .env.local .env; \
		echo ".env.local から .env を作成しました"; \
	else \
		echo ".env は既に存在するためスキップしました"; \
	fi

.PHONY: app-clean
app-clean:
	$(call print_headline,${@})
	@docker-compose exec -T -u 0 -w /var/www/source $(NAME) sh -c 'chown -R 1000:1000 storage bootstrap/cache && chmod -R 755 storage bootstrap/cache && rm -rf storage/framework/cache/*'
	@$(MAKE) artisan-run ARGS="config:clear"
	@$(MAKE) artisan-run ARGS="cache:clear"
	@$(MAKE) artisan-run ARGS="view:clear"
	@$(MAKE) artisan-run ARGS="optimize:clear"
	@$(MAKE) composer-dump
	@$(MAKE) job-restart

.PHONY: app-reset
app-reset:
	$(call print_headline,${@})
	@$(MAKE) migrate-fresh-all
	@$(MAKE) migrate-all
	@$(MAKE) migrate-seeder-dev

.PHONY: app-route
app-route:
	$(call print_headline,${@})
	@$(MAKE) artisan-route

.PHONY: app-autoload
app-autoload:
	$(call print_headline,${@})
	@$(MAKE) composer-dump

# 旧記述(App\Core、MdlForwardPod、CntSandbox など)が、コードに残っていないか検出する。
.PHONY: app-legacy-check
app-legacy-check:
	$(call print_headline,${@})
	@cd .. && if grep -rnE --exclude=DevLog.php 'App\\Core|ForwardPod|forward_pod|CntSandbox|CntProxy' app routes bootstrap config tests database composer.json 2>/dev/null; then \
		echo "[NG] 旧記述が残っています"; exit 1; \
	else \
		echo "[OK] 旧記述の残りはありません"; \
	fi
