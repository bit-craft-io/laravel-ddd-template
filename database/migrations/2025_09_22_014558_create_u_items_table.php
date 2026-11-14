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
        Schema::create('u_items', function (Blueprint $table) {
            $table->id()->comment('識別子');
            $table->unsignedBigInteger('user_id')->default(1)->comment('内部用ユーザ識別子');
            $table->unsignedBigInteger('item_id')->default(1)->comment('アイテム識別子');
            $table->unsignedInteger('amount')->default(1)->comment('所持数');
            // @note 検索時に使用
            $table->timestamp('end_at')->nullable()->comment('有効期間（終了日時）');
            $table->timestamps();

            $table->unique(['user_id', 'item_id'], 'user_id_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_items');
    }
};
