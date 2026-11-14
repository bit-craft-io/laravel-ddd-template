#!/usr/bin/env bash
# メインメニュー(グループ)→ サブメニュー(タスク)を表示して、選んだタスクを実行する。
# docker/ で実行する。グループは Makefile の `include make.d/<名前>.mk` から、
# タスクは各 .mk の `TASKS += \` のブロック(`名前:説明`)から読む。
set -u
trap 'echo; exit 0' INT

groups() {
    awk '/^include make\.d\// {print $2}' Makefile | xargs -n1 basename | sed 's/\.mk$//' | grep -v '^_' | awk '!v[$0]++'
}

group_desc() {
    sed -n 's/^# GROUP: *//p' "make.d/$1.mk" | head -n1
}

tasks_of() {
    awk '/^TASKS *\+=/,/[^\\]$/' "make.d/$1.mk" \
        | sed -e 's/^TASKS *+=//' -e 's/\\$//' -e 's/^[[:space:]]*//' -e 's/[[:space:]]*$//' \
        | grep -v '^$'
}

# 番号を選ばせる。$1=最大の番号。結果は REPLY_NUM に入れる。
ask_number() {
    local max=$1 n
    while true; do
        read -r -p "??: " n || exit 0
        if [[ "$n" =~ ^[0-9]+$ ]] && [ "$n" -ge 1 ] && [ "$n" -le "$max" ]; then
            REPLY_NUM=$n
            return
        fi
        echo "1〜${max} の番号を入力してください"
    done
}

mapfile -t G < <(groups)
if [ "${#G[@]}" -eq 0 ]; then
    echo "Makefile に make.d/*.mk の include がありません"
    exit 1
fi

echo "--- Select Group ---"
printf "%2d) %-12s # %s\n" 1 "_exit" "終了"
i=2
for g in "${G[@]}"; do
    printf "%2d) %-12s # %s\n" "$i" "$g" "$(group_desc "$g")"
    i=$((i + 1))
done
ask_number $((${#G[@]} + 1))
[ "$REPLY_NUM" -eq 1 ] && exit 0
sel_group=${G[$((REPLY_NUM - 2))]}

mapfile -t T < <(tasks_of "$sel_group")
echo "--- Select Task [$sel_group] ---"
printf "%2d) %-20s # %s\n" 1 "_back" "メインメニューに戻る"
i=2
for t in "${T[@]}"; do
    printf "%2d) %-20s # %s\n" "$i" "${t%%:*}" "${t#*:}"
    i=$((i + 1))
done
ask_number $((${#T[@]} + 1))
if [ "$REPLY_NUM" -eq 1 ]; then
    exec make --no-print-directory menu
fi
sel_task=${T[$((REPLY_NUM - 2))]}
export FROM_MENU=1   # 見出しに、直接実行できる make の1行を出すため(header.sh)
exec make --no-print-directory "${sel_task%%:*}"
