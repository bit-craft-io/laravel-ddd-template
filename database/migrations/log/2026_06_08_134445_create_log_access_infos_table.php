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
        Schema::create('log_access_infos', function (Blueprint $table) {
            $table->id()->comment('識別子');
            $table->unsignedBigInteger('user_id')->default(0)->comment('内部用ユーザ識別子');
            $table->string('public_id', 12)->default('')->comment('外部公開用ユーザ識別子');
            $table->unsignedSmallInteger('level')->default(1)->comment('ログレベル');
            $table->string('api', 256)->nullable()->comment('実行API');
            $table->json('param')->default(new Expression('(JSON_OBJECT())'))->comment('パラメータ');
            $table->string('file', 256)->nullable()->comment('発生ファイル');
            $table->unsignedInteger('line')->default(0)->comment('発生行');
            $table->json('option_info')->default(new Expression('(JSON_OBJECT())'))->comment('オプション項目');
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_access_infos');
    }
};
