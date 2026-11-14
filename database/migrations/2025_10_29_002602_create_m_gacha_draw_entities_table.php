<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_gacha_draw_entities', function (Blueprint $table) {
            $table->id()->comment('識別子');
            $table->boolean('is_active')->default(false)->comment('公開中');
            $table->timestamp('begin_at')->nullable()->comment('有効期間（開始日時）');
            $table->timestamp('end_at')->nullable()->comment('有効期間（終了日時）');
            $table->unsignedInteger('group_no')->default(0)->comment('グループ番号');
            $table->unsignedTinyInteger('type_rarity')->default(1)->comment('レアリティ（1: N | 2: R | 3:SR | 4:UR | 4:LR）');
            $table->unsignedBigInteger('type_entity')->comment('エンティティタイプ（1: アイテム | 2: プレイアブル）');
            $table->unsignedBigInteger('entity_id')->comment('エンティティID');
            $table->unsignedBigInteger('entity_amount')->comment('エンティティ個数');
            $table->unsignedInteger('rate')->default(0)->comment('抽選率');
            $table->string('ops_memo', 128)->nullable()->comment('運用メモ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_gacha_draw_entities');
    }
};
