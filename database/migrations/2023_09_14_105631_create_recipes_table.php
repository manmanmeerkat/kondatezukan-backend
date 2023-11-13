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
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('reference_url')->nullable();
            $table->timestamps();

            $table->foreignId('genre_id')->constrained('genres');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('user_id')->constrained('users')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};
