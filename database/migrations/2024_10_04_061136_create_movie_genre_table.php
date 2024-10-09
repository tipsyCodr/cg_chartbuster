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
        // Schema::disableForeignKeyConstraints();

        Schema::create('movie_genre', function (Blueprint $table) {
            $table->integer('movie_id')->primary();
            // $table->foreign('movie_id')->references('id')->on('movies');
            $table->integer('genre_id');
            // $table->foreign('genre_id')->references('id')->on('genres');
            $table->timestamps();

        });

        // Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_genre');
    }
};
