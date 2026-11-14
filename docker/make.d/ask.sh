#!/usr/bin/env bash
# 自由入力を求める。使い方: ask.sh <ラベル>
# 入力値を stdout に出す。空なら中止(終了コード 1)。端末でないときは、中止する。
if [ ! -t 0 ]; then
    echo "入力が必要です(変数で指定してください)" >&2
    exit 1
fi
read -r -p "$1: " v || exit 1
[ -n "$v" ] || { echo "中止しました" >&2; exit 1; }
echo "$v"
