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
        Schema::create('m_demo_products', function (Blueprint $table) {
            $table->id()->comment('識別子');
            $table->boolean('is_active')->default(false)->comment('公開中');
            $table->timestamp('begin_at')->nullable()->comment('有効期間（開始日時）');
            $table->timestamp('end_at')->nullable()->comment('有効期間（終了日時）');
            $table->string('name', 64)->comment('名前');
            $table->unsignedInteger('price')->default(0)->comment('価格');
            $table->unsignedInteger('purchase_limit')->default(0)->comment('1 ユーザの購入上限数（0: 上限なし）');
            $table->unsignedSmallInteger('display_order')->default(0)->comment('表示順');
            $table->string('ops_memo', 128)->nullable()->comment('運用メモ');
            $table->timestamp('created_at')->nullable()->comment('作成日時');
            $table->timestamp('updated_at')->nullable()->comment('更新日時');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_demo_products');
    }
};
