<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DevLog extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('log_access_infos')->truncate();
        $queries[] = /** @lang text */
            <<<'QUERY'
insert into log_access_infos (id, user_id, public_id, level, api, param, file, line, option_info, created_at, updated_at) values
(1, 1, '', 0, 'api/sandbox/set-que', '{"user_id": 1}', 'app/Http/Controllers/CntSandbox.php', 22, '{"debug": 99}', '2026-06-10 14:32:12', '2026-06-10 14:32:12'),
(2, 1, '', 0, 'api/sandbox/set-que', '{"user_id": 1}', 'app/Http/Controllers/CntSandbox.php', 22, '{"debug": 99}', '2026-06-10 14:32:18', '2026-06-10 14:32:18'),
(3, 1, '', 0, 'api/sandbox/set-que', '{"user_id": 1}', 'app/Http/Controllers/CntSandbox.php', 22, '{"debug": 99}', '2026-06-10 14:32:18', '2026-06-10 14:32:18'),
(4, 1, '', 0, 'api/sandbox/set-que', '{"user_id": 1}', 'app/Http/Controllers/CntSandbox.php', 22, '{"debug": 99}', '2026-06-10 14:32:21', '2026-06-10 14:32:21'),
(5, 1, '', 0, 'api/sandbox/set-que', '{"user_id": 1}', 'app/Http/Controllers/CntSandbox.php', 22, '{"debug": 99}', '2026-06-10 14:32:24', '2026-06-10 14:32:24')
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
