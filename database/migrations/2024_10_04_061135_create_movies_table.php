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

        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->date('release_date')->nullable();
            $table->string('genre', 255)->nullable();
            $table->integer('duration')->nullable();
            $table->string('director', 255)->nullable();
            $table->string('poster_image', 255)->nullable();
            $table->string('trailer_url', 255)->nullable();
            $table->timestamps();

        });

        // Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
