<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DevUser extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('accounts')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into accounts (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) values
(1, 'none', 'ksuyra4g49ti@bit-craft.com', null, '$2y$12$nfrDclo7NqeTlvE20lP7c.nVBZT56SjdGR2eXq0SOeQYh2Xvmpx7y', null, '2026-06-10 15:17:25', '2026-06-10 15:17:25');
QUERY;

        DB::table('u_users')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into u_users (id, public_id, nick_name, meta_data) values
(1, 'ksuyra4g49ti', 'none', '{}')
;
QUERY;

        DB::table('u_items')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into u_items (user_id, item_id, amount, end_at) values
(1, 1, 9900, null), (1, 2, 1000, null), (1, 3, 1000, null)
;
QUERY;

        DB::table('u_gachas')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into u_gachas (user_id, gacha_info)
values  (1, '{"1": {"exec_at": "2026-06-10 15:07:08", "exec_count": 1, "expired_at": ""}, "2": {"exec_at": "2026-06-10 15:07:14", "exec_count": 1, "expired_at": ""}, "3": {"exec_at": "2026-06-10 15:06:32", "exec_count": 1, "expired_at": ""}}');
QUERY;

        foreach ($queries as $query) {
            if ($query) {
                DB::unprepared($query);
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
