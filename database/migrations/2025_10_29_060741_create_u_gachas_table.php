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
        Schema::create('u_gachas', function (Blueprint $table) {
            $table->id()->comment('識別子');
            $table->unsignedBigInteger('user_id')->comment('内部用ユーザ識別子');
            $table->json('gacha_info')->nullable()->comment('ユーザガチャ情報')->default(new Expression('(JSON_OBJECT())'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_gachas');
    }
};
