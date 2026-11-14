# GROUP: コンポーサーの操作
# ========================================
# menu
# ----------------------------------------
TASKS += \
	composer-install:パッケージをインストールする \
	composer-update:パッケージを更新する \
	composer-dump:オートロードを再生成する \
	composer-run:コマンドを実行する（入力あり）
# ========================================
# command
# ----------------------------------------
.PHONY: composer-install
composer-install:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) composer install

.PHONY: composer-update
composer-update:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) composer update

.PHONY: composer-dump
composer-dump:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) composer dump-autoload

# 引数は ARGS で指定する(例: make composer-run ARGS="require foo/bar")。未指定なら、入力を求める。
.PHONY: composer-run
composer-run:
	@args="$(ARGS)"; \
	[ -n "$$args" ] || args=$$(bash make.d/ask.sh "composer の引数") || exit 1; \
	bash make.d/header.sh composer-run "ARGS=$$args"; \
	$(DOCKER_EXEC) composer $$args
