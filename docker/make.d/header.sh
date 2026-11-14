#!/usr/bin/env bash
# 実行前の見出しを表示する。使い方: header.sh <タスク名> [変数=値 ...]
# 最上位の実行(HDR_TOP が空でない)のときだけ、直接実行できる make の1行を出す。
task=$1
shift
line="----------------------------------------------------------------"

if [ -n "${HDR_TOP:-}" ]; then
    cmd="make $task"
    for kv in "$@"; do
        k=${kv%%=*}
        v=${kv#*=}
        if [[ "$v" =~ [[:space:]] ]]; then
            cmd="$cmd $k='$v'"
        else
            cmd="$cmd $k=$v"
        fi
    done
    echo "================================================================"
    echo ">>> command: $cmd"
fi
echo "$line"
echo ">>> execute: [ $task ]"
echo "$line"
