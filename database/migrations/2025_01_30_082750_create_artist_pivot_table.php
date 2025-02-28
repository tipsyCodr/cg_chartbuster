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
        
        Schema::table('artists', function (Blueprint $table) {
            $table->id()->change();
        });
        Schema::table('movies', function (Blueprint $table) {
            $table->id()->change();
        });
    

        Schema::create('artist_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->foreignId('artist_category_id')->constrained('artist_category')->onDelete('cascade');  // Updated to use category ID
            $table->string('role')->nullable();
            $table->timestamps();
        });
        
        Schema::create('artist_song', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('song_id')->constrained()->onDelete('cascade');
            $table->foreignId('artist_category_id')->constrained('artist_category')->onDelete('cascade');  // Updated to use category ID
            $table->string('role')->nullable();
            $table->timestamps();
        });
        
        Schema::create('artist_tvshow', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->onDelete('cascade');
            $table->foreignId('tvshow_id')->constrained()->onDelete('cascade');
            $table->foreignId('artist_category_id')->constrained('artist_category')->onDelete('cascade');  // Updated to use category ID
            $table->string('role')->nullable();
            $table->timestamps();
        });
        
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('artists');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artist_movie');
        Schema::dropIfExists('artist_song');
        Schema::dropIfExists('artist_tvshow');
        Schema::table('songs', function (Blueprint $table) {
            $table->string('artists', 255)->nullable();

        });
    }
};
