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
        Schema::create('u_demo_purchases', function (Blueprint $table) {
            $table->id()->comment('識別子');
            $table->foreignId('user_id')->comment('内部用ユーザ識別子')->constrained('u_users')->restrictOnDelete();
            $table->foreignId('product_id')->comment('商品識別子')->constrained('m_demo_products')->restrictOnDelete();
            $table->unsignedInteger('quantity')->default(0)->comment('購入数');
            $table->unsignedInteger('total_price')->default(0)->comment('合計価格');
            $table->string('purchase_no', 32)->comment('購入番号');
            $table->timestamp('created_at')->nullable()->comment('作成日時');
            $table->timestamp('updated_at')->nullable()->comment('更新日時');
            $table->softDeletes()->comment('削除日時');

            $table->unique(['purchase_no'], 'unique_purchase_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_demo_purchases');
    }
};
