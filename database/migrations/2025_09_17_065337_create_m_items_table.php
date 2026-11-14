<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use SoftDeletes;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_items', function (Blueprint $table) {
            $table->id()->comment('識別子');
            $table->boolean('is_active')->default(false)->comment('公開中');
            $table->timestamp('begin_at')->nullable()->comment('有効期間（開始日時）');
            $table->timestamp('end_at')->nullable()->comment('有効期間（終了日時）');
            $table->string('name', 64)->nullable()->comment('名前');
            $table->unsignedTinyInteger('type_item')->default(1)->comment('アイテムタイプ（1: 消耗アイテム | 2: 永続アイテム | 3:装備アイテム | 4:素材アイテム）');
            $table->unsignedInteger('max_display')->default(1)->comment('表示最大値');
            $table->unsignedInteger('max_stock')->default(1)->comment('所持最大値');
            $table->string('ops_memo', 128)->nullable()->comment('運用メモ');
            $table->timestamps();

            $table->index(['type_item'], 'type_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_items');
    }
};
