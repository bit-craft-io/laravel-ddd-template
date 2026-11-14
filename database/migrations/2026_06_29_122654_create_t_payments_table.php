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
        Schema::create('t_payments', function (Blueprint $table) {
            $table->id()->autoIncrement()->comment('識別子');
            $table->string('transaction_id')->nullable()->comment('トランザクション識別子');
            $table->unsignedBigInteger('user_id')->default(1)->comment('内部用ユーザ識別子');
            $table->unsignedTinyInteger('type_store')->default(1)->comment('ストアタイプ（1: apple | 2: google）');
            $table->unsignedTinyInteger('type_currency')->default(1)->comment('通貨タイプ（1: jpn | 2: usd）');
            $table->unsignedTinyInteger('type_progress')->comment('進捗タイプ（1: processing | 2: success | 3: failed）');
            $table->unsignedBigInteger('purchased_item_id')->default(1)->comment('購入アイテム識別子');
            $table->unsignedInteger('purchased_amount')->comment('購入個数');
            $table->timestamps();

            $table->unique(['transaction_id'], 'transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_payments');
    }
};
