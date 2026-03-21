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
        $tables = ['movies', 'songs', 'tvshows'];

        foreach ($tables as $tableName) {
            // Step 1: Rename the column if it hasn't been renamed yet (partial failure guard)
            if (Schema::hasColumn($tableName, 'genre')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->renameColumn('genre', 'genre_id');
                });
            }

            // Step 2: Ensure type matches genres.id (which is signed INT)
            Schema::table($tableName, function (Blueprint $table) {
                $table->integer('genre_id')->nullable()->change();
            });

            // Step 3: Add foreign key constraint
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreign('genre_id')->references('id')->on('genres')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['movies', 'songs', 'tvshows'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'genre_id')) {
                    // Try to drop foreign key (swallow error if it doesn't exist to allow rolling back dirty state)
                    try {
                        $table->dropForeign(['genre_id']);
                    } catch (\Exception $e) {
                         // Fallback for some drivers/versions
                         // $table->dropForeign($tableName . '_genre_id_foreign');
                    }
                    
                    $table->renameColumn('genre_id', 'genre');
                }
            });

            if (Schema::hasColumn($tableName, 'genre')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->string('genre', 255)->nullable()->change();
                });
            }
        }
    }
};
