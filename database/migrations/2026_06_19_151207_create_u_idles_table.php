<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('u_idles', function (Blueprint $table) {
            $table->id()->comment('識別子');
            $table->unsignedBigInteger('user_id')->default(1)->comment('内部用ユーザ識別子');
            $table->unsignedSmallInteger('type_idle')->default(1)->comment('放置タイプ（1: energy | 2: craft）');
            $table->unsignedSmallInteger('index_no')->default(1)->comment('放置タイプ毎のインデックス番号');
            $table->string('progress_id', 32)->nullable()->comment('進捗ID');
            $table->datetime('begin_at')->nullable()->comment('開始日時');
            $table->datetime('end_at')->nullable()->comment('終了日時');
            $table->unsignedInteger('end_forward_sec')->default(0)->comment('終了日時の前倒し秒数');
            $table->json('stash_contents')->default(new Expression('(JSON_ARRAY())'))->comment('獲得予定内容');
            $table->timestamps();

            $table->unique(['user_id', 'type_idle', 'index_no'], 'user_id_type_idle_index_no');
            $table->index(['progress_id'], 'progress_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_idles');
    }
};
