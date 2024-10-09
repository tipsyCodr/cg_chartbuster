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

        Schema::create('comments', function (Blueprint $table) {
            $table->integer('id')->primary()->autoIncrement();
            $table->integer('review_id');
            // $table->foreign('review_id')->references('id')->on('reviews');
            $table->integer('user_id');
            // $table->foreign('user_id')->references('id')->on('users');
            $table->text('comment_text');
            $table->timestamps();

        });

        // Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
