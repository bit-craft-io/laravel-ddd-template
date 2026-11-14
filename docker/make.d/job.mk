# GROUP: ジョブ（キュー）の操作
# ========================================
# menu
# ----------------------------------------
TASKS += \
	job-restart-dev:ジョブを監視して再読み込みする \
	job-restart:ワーカーを再起動する \
	job-work:ワーカーを起動する
# ========================================
# command
# ----------------------------------------
# @note 【開発用】Job変更時にソースコードを自動で再読み込みする(queue:restart不要)
.PHONY: job-restart-dev
job-restart-dev:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) php artisan queue:listen

.PHONY: job-restart
job-restart:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) php artisan queue:restart

.PHONY: job-work
job-work:
	$(call print_headline,${@})
	@$(DOCKER_EXEC) php artisan queue:work
