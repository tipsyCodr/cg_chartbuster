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
        //change to text
        Schema::table('movies', function (Blueprint $table) {
            $table->text('trailer_url')->nullable()->change();
        });
        Schema::table('tvshows', function (Blueprint $table) {
            $table->text('trailer_url')->nullable()->change();
        });
        Schema::table('songs', function (Blueprint $table) {
            $table->text('trailer_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //change back to varchar
        Schema::table('movies', function (Blueprint $table) {
            $table->string('trailer_url')->nullable()->change();
        });
        Schema::table('tvshows', function (Blueprint $table) {
            $table->string('trailer_url')->nullable()->change();
        });
        Schema::table('songs', function (Blueprint $table) {
            $table->string('trailer_url')->nullable()->change();
        });
    }
};
