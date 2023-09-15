<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('genre')->nullable(); // ジャンルを格納するカラムを追加
            $table->string('category')->nullable(); // カテゴリーを格納するカラムを追加
            $table->string('image_path')->nullable(); // 画像を格納するカラムを追加
            $table->string('reference_url')->nullable(); // 参考URLを追加
            $table->unsignedBigInteger('user_id')->default(1);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};
