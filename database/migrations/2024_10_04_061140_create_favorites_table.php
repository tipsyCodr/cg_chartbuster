<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('favorites', function (Blueprint $table) {
            $table->integer('id')->primary()->autoIncrement();
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users');
            $table->integer('movie_id');
            // $table->foreign('movie_id')->references('id')->on('movies');
            $table->timestamps();

        });

        // Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
