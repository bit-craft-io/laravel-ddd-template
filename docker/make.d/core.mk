# GROUP: コア（サブモジュール）の操作
# ========================================
# menu
# ----------------------------------------
TASKS += \
	core-init:コアを取得する \
	core-status:コアの状態を表示する \
	core-update:コアを切り替える（選択あり）
# ========================================
# command
# ----------------------------------------
.PHONY: core-init
core-init:
	$(call print_headline,${@})
	@cd .. && git submodule update --init

.PHONY: core-status
core-status:
	$(call print_headline,${@})
	@cd .. && \
	ptr=$$(git ls-tree HEAD $(CORE_DIR) | awk '{print $$3}'); \
	[ -n "$$ptr" ] || { echo "[NG] サブモジュールが登録されていません"; exit 1; }; \
	echo "親が指すコミット   : $$ptr"; \
	[ -e $(CORE_DIR)/.git ] || { echo "[NG] 未取得です(core-init を実行してください)"; exit 1; }; \
	git -C $(CORE_DIR) fetch -q origin 2>&1 | tail -n 1; \
	echo "作業ツリーの HEAD : $$(git -C $(CORE_DIR) rev-parse HEAD)"; \
	if git -C $(CORE_DIR) merge-base --is-ancestor $$ptr origin/main 2>/dev/null; then \
		echo "[OK] 指すコミットは origin/main に含まれています"; \
	else \
		echo "[WARN] 指すコミットが origin/main に含まれていません(または取得できていません)"; \
	fi

# origin は固定。ブランチは CORE_REF で指定する(未指定なら、番号で選ぶ。既定は main)。
.PHONY: core-update
core-update:
	@[ -e ../$(CORE_DIR)/.git ] || { echo "[NG] core が未取得です(core-init を実行してください)"; exit 1; }
	@ref="$(CORE_REF)"; \
	[ -n "$$ref" ] || ref=$$(bash make.d/choose.sh "ブランチ" main develop) || exit 1; \
	bash make.d/header.sh core-update "CORE_REF=$$ref"; \
	cd .. && git -C $(CORE_DIR) fetch origin && \
	git -C $(CORE_DIR) checkout origin/$$ref && \
	echo "次: git add $(CORE_DIR)(コミットは、人が行ってください)"
