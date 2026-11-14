# GROUP: テストの操作
# ========================================
# menu
# ----------------------------------------
TASKS += \
	test-all:全テストを実行する \
	test-unit:ユニットテストを実行する \
	test-feature:機能テストを実行する
# ========================================
# command
# ----------------------------------------
.PHONY: test-all
test-all:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) php artisan test

.PHONY: test-unit
test-unit:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) php artisan test --testsuite=Unit

.PHONY: test-feature
test-feature:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) php artisan test --testsuite=Feature
