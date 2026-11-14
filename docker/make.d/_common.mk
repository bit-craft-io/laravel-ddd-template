# ========================================
# common
# ----------------------------------------
# 最上位の実行か(直接実行: MAKELEVEL=0、メニュー経由: MAKELEVEL=1 かつ FROM_MENU=1)。
# 最上位のときだけ、直接実行できる make の1行を見出しに出す(header.sh)。
HDR_TOP :=
ifeq ($(MAKELEVEL),0)
HDR_TOP := 1
endif
ifeq ($(MAKELEVEL)$(FROM_MENU),11)
HDR_TOP := 1
endif

define print_headline
	@bash make.d/header.sh $(1)
endef

# このリポジトリのルート(docker/ の親)と、core(サブモジュール)
ROOT_DIR := $(abspath ..)
CORE_DIR := submodules/laravel-ddd-core
# core のマイグレーション(Laravel のルートからの相対パス。コンテナ内の作業ディレクトリ)。R8
CORE_MIGRATION_PATH := $(CORE_DIR)/database/migrations

# 引数が必要なタスクの変数(指定すると、質問を飛ばす)
ARGS     ?=
CORE_REF ?=
DB_NAME  ?=
