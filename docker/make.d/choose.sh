#!/usr/bin/env bash
# 候補から番号で選ばせる。使い方: choose.sh <ラベル> <候補>...
# 選んだ値を stdout に出す(表示は stderr)。末尾に「入力」を足す。空なら中止(終了コード 1)。
# 端末でないとき(スクリプトからの呼び出し)は、最初の候補を返す。
label=$1; shift
opts=("$@")
if [ ! -t 0 ]; then
    echo "${opts[0]}"
    exit 0
fi
line=""
i=1
for o in "${opts[@]}"; do
    line="$line $i) $o "
    i=$((i + 1))
done
line="$line $i) 入力"
echo "$line" >&2
while true; do
    read -r -p "$label ??: " n || exit 1
    if [[ "$n" =~ ^[0-9]+$ ]] && [ "$n" -ge 1 ] && [ "$n" -le "$i" ]; then
        break
    fi
    echo "1〜${i} の番号を入力してください" >&2
done
if [ "$n" -eq "$i" ]; then
    read -r -p "$label: " v || exit 1
    [ -n "$v" ] || { echo "中止しました" >&2; exit 1; }
    echo "$v"
else
    echo "${opts[$((n - 1))]}"
fi
