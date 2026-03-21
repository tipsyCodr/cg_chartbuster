<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Pivot tables
        $tables = [
            'movie_genre' => 'movies',
            'song_genre' => 'songs',
            'tvshow_genre' => 'tvshows'
        ];

        foreach ($tables as $pivotTable => $parentTable) {
            // Drop it if already exists (botched state) or ensure structure
            Schema::dropIfExists($pivotTable);

            Schema::create($pivotTable, function (Blueprint $table) use ($pivotTable, $parentTable) {
                // Determine ID column name (e.g., movie_id, song_id, tvshow_id)
                $idCol = str_replace('_genre', '', $pivotTable) . '_id';
                
                // Foreign keys
                $table->unsignedBigInteger($idCol);
                $table->integer('genre_id'); // Match genres.id (INT)
                $table->timestamps();
                
                $table->foreign($idCol)->references('id')->on($parentTable)->onDelete('cascade');
                $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
                
                $table->primary([$idCol, 'genre_id']);
            });
        }

        // 2. Data Migration: Migrate existing genre_id to pivot table
        foreach (['movies', 'songs', 'tvshows'] as $t) {
            $pivotName = ($t === 'tvshows') ? 'tvshow_genre' : ( ( $t === 'songs' ) ? 'song_genre' : 'movie_genre' );
            $idCol = ($t === 'tvshows') ? 'tvshow_id' : ( ( $t === 'songs' ) ? 'song_id' : 'movie_id' );

            DB::statement("
                INSERT INTO {$pivotName} ({$idCol}, genre_id, created_at, updated_at)
                SELECT id, genre_id, NOW(), NOW() 
                FROM {$t} 
                WHERE genre_id IS NOT NULL 
                AND EXISTS (SELECT 1 FROM genres WHERE genres.id = {$t}.genre_id)
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_genre');
        Schema::dropIfExists('song_genre');
        Schema::dropIfExists('tvshow_genre');
    }
};
