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
        Schema::disableForeignKeyConstraints();
        $tables = ['movies', 'songs', 'tvshows'];

        foreach ($tables as $tableName) {
            // Step 1: Rename the column if it hasn't been renamed yet
            if (Schema::hasColumn($tableName, 'genre')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->renameColumn('genre', 'genre_id');
                });
            }

            // Step 2: Ensure type matches genres.id (which is signed INT)
            Schema::table($tableName, function (Blueprint $table) {
                $table->integer('genre_id')->nullable()->change();
            });

            // Step 3: Add foreign key constraint ONLY if it doesn't exist
            // This avoids "Duplicate foreign key constraint name" error (MySQL Error 1826) 
            // from previous aborted runs.
            $foreignKeyName = $tableName . '_genre_id_foreign';
            $exists = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.REFERENTIAL_CONSTRAINTS 
                WHERE CONSTRAINT_SCHEMA = DATABASE() 
                AND TABLE_NAME = ? 
                AND CONSTRAINT_NAME = ?
            ", [$tableName, $foreignKeyName]);

            if (empty($exists)) {
                Schema::table($tableName, function (Blueprint $table) use ($foreignKeyName) {
                    $table->foreign('genre_id', $foreignKeyName)->references('id')->on('genres')->onDelete('set null');
                });
            }
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        $tables = ['movies', 'songs', 'tvshows'];

        foreach ($tables as $tableName) {
            $foreignKeyName = $tableName . '_genre_id_foreign';
            
            Schema::table($tableName, function (Blueprint $table) use ($tableName, $foreignKeyName) {
                // Check if foreign key exists before dropping
                $exists = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.REFERENTIAL_CONSTRAINTS 
                    WHERE CONSTRAINT_SCHEMA = DATABASE() 
                    AND TABLE_NAME = ? 
                    AND CONSTRAINT_NAME = ?
                ", [$tableName, $foreignKeyName]);

                if (!empty($exists)) {
                    $table->dropForeign($foreignKeyName);
                }

                if (Schema::hasColumn($tableName, 'genre_id')) {
                    $table->renameColumn('genre_id', 'genre');
                }
            });

            if (Schema::hasColumn($tableName, 'genre')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->string('genre', 255)->nullable()->change();
                });
            }
        }
        Schema::enableForeignKeyConstraints();
    }
};
