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
        Schema::create('m_payments', function (Blueprint $table) {
            $table->id()->comment('識別子（任意）');
            $table->unsignedTinyInteger('type_store')->default(1)->comment('ストアタイプ（1: apple | 2: google）');
            $table->string('product_id')->comment('ストア識別子');
            $table->unsignedInteger('credit_amount')->comment('クレジット数');
            $table->timestamps();

            $table->unique(['type_store', 'product_id'], 'type_store_product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_payments');
    }
};
