# GROUP: コード検査の操作
# ========================================
# menu
# ----------------------------------------
TASKS += \
	php-check:規約と静的解析を確認する \
	php-fix-dry:規約の違反を表示する \
	php-fix:コードを整形する \
	php-stan:静的解析を実行する \
	php-except:例外コードを確認する
# ========================================
# command
# ----------------------------------------
.PHONY: php-check
php-check:
	$(call print_headline,${@})
	@$(MAKE) php-fix-dry
	@$(MAKE) php-stan

.PHONY: php-fix-dry
php-fix-dry:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) vendor/bin/php-cs-fixer fix --dry-run --diff

.PHONY: php-fix
php-fix:
	@read -p "commit? [y/N]: " ans && [ "$$ans" = "y" ]
	@$(DOCKER_EXEC) vendor/bin/php-cs-fixer fix --diff

.PHONY: php-stan
php-stan:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) vendor/bin/phpstan analyse

# 例外コードの enum を検査する(core の bin)。ディレクトリが無いときは、エラーにする。
.PHONY: php-except
php-except:
	$(call print_headline,${@})
	@[ -d ../app/Exceptions/Enum ] || { echo "[NG] app/Exceptions/Enum がありません"; exit 1; }
	@$(DOCKER_EXEC) vendor/bin/except-code-check app/Exceptions/Enum 'App\Exceptions\Enum'
