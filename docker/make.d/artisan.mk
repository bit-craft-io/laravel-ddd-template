# GROUP: アルチザンの操作
# ========================================
# menu
# ----------------------------------------
TASKS += \
	artisan-route:ルートを表示する \
	artisan-tinker:ティンカーを起動する \
	artisan-run:コマンドを実行する（入力あり）
# ========================================
# command
# ----------------------------------------
.PHONY: artisan-route
artisan-route:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) php artisan route:list

.PHONY: artisan-tinker
artisan-tinker:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) php artisan tinker

# 引数は ARGS で指定する(例: make artisan-run ARGS="config:clear")。未指定なら、入力を求める。
.PHONY: artisan-run
artisan-run:
	@args="$(ARGS)"; \
	[ -n "$$args" ] || args=$$(bash make.d/ask.sh "artisan の引数") || exit 1; \
	bash make.d/header.sh artisan-run "ARGS=$$args"; \
	$(DOCKER_EXEC) php artisan $$args
