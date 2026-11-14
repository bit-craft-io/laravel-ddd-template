<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DevMaster extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('m_items')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into m_items (is_active, begin_at, end_at, name, type_item, max_display, max_stock, ops_memo) values
(1, null, null, 'coin', 1, 99999999, 999999999, null),
(1, null, null, 'ticket_a', 1, 999, 9999, null),
(1, null, null, 'ticket_b', 1, 99, 99, null),
(1, null, null, 'elixir', 1, 999, 9999, null),
(1, null, null, 'potion', 1, 999, 9999, null),
(1, null, null, 'seal', 2, 1, 1, null),
(1, null, null, 'badge', 2, 1, 1, null),
(1, null, null, 'sword', 3, 99, 99, null),
(1, null, null, 'shield', 3, 99, 99, null),
(1, null, null, 'material_a', 4, 9999, 9999, null),
(1, null, null, 'material_b', 4, 9999, 9999, null)
;
QUERY;

        DB::table('m_gachas')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into m_gachas (is_active, begin_at, end_at, name, type_draw, group_no, exec_count, exec_count_limit, type_cost, cost_id, total_cost_amount, draw_count, gacha_draw_rarity_group_no, gacha_draw_entity_group_no, display_order, banner_image_name, ops_memo) values
(1, '2025-01-01 00:00:00', '2038-01-01 00:00:00', 'Normal', 1, 1, 0, 0, 1, 1, 100, 3, 0, 1, 1, null, null),
(1, '2025-01-01 00:00:00', '2038-01-01 00:00:00', 'Step', 2, 2, 0, 4, 1, 1, 100, 10, 0, 1, 1, null, null),
(1, '2025-01-01 00:00:00', '2038-01-01 00:00:00', 'Step', 2, 2, 1, 4, 1, 1, 100, 10, 0, 2, 1, null, null),
(1, '2025-01-01 00:00:00', '2038-01-01 00:00:00', 'Fixed', 3, 3, 0, 0, 1, 1, 1000, 10, 0, 1, 1, null, null),
(1, '2025-01-01 00:00:00', '2038-01-01 00:00:00', 'Rarity', 4, 4, 0, 0, 1, 1, 100, 3, 2, 2, 1, null, null)
;
QUERY;

        DB::table('m_gacha_draw_entities')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into m_gacha_draw_entities (is_active, begin_at, end_at, group_no, type_rarity, type_entity, entity_id, entity_amount, rate, ops_memo) values
(1, null, null, 1, 1, 1, 1, 1000, 5000, null),
(1, null, null, 1, 1, 1, 2, 1, 1500, null),
(1, null, null, 1, 2, 1, 3, 1, 500, null),
(1, null, null, 1, 3, 1, 4, 1, 1500, null),
(1, null, null, 1, 4, 1, 5, 1, 1500, null),
(1, null, null, 2, 1, 1, 8, 1, 1500, null),
(1, null, null, 2, 1, 1, 9, 1, 1500, null),
(1, null, null, 2, 2, 1, 10, 1, 1500, null),
(1, null, null, 2, 3, 1, 11, 1, 1500, null),
(1, null, null, 2, 4, 1, 5, 3, 4000, null)
;
QUERY;

        DB::table('m_gacha_draw_rarities')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into m_gacha_draw_rarities (is_active, begin_at, end_at, group_no, type_rarity, rate, ops_memo) values
(1, null, null, 1, 1, 7000, null),
(1, null, null, 1, 3, 2500, null),
(1, null, null, 1, 3, 400, null),
(1, null, null, 1, 4, 100, null),
(1, null, null, 2, 1, 1000, null),
(1, null, null, 2, 3, 1500, null),
(1, null, null, 2, 3, 5000, null),
(1, null, null, 2, 4, 2500, null)
;
QUERY;

        DB::table('m_demo_products')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into m_demo_products (is_active, begin_at, end_at, name, price, purchase_limit, display_order, ops_memo) values
(1, null, null, 'demo_product_a', 100, 0, 1, '公開中・購入上限なし'),
(1, null, null, 'demo_product_b', 300, 3, 2, '公開中・購入上限あり'),
(0, null, null, 'demo_product_c', 500, 0, 3, '非公開')
;
QUERY;

        foreach ($queries as $query) {
            if ($query) {
                DB::unprepared($query);
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
