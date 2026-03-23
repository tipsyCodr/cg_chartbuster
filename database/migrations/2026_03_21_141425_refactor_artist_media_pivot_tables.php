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
        $tables = [
            'artist_movie' => 'movie_id',
            'artist_song' => 'song_id',
            'artist_tvshow' => 'tvshow_id',
        ];

        foreach ($tables as $table => $foreignKey) {
            // 1. Add new JSON column
            if (!Schema::hasColumn($table, 'artist_category_ids')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->json('artist_category_ids')->nullable()->after('artist_id');
                });
            }

            // 2. Migrate data
            $entries = DB::table($table)->get();
            $grouped = $entries->groupBy(function ($entry) use ($foreignKey) {
                return $entry->artist_id . '-' . $entry->$foreignKey;
            });

            foreach ($grouped as $key => $items) {
                $categoryIds = $items->pluck('artist_category_id')->unique()->filter()->values()->toArray();
                
                // Get the first ID to keep
                $firstId = $items->first()->id;
                $otherIds = $items->slice(1)->pluck('id')->toArray();

                // Update the first entry with all category IDs
                DB::table($table)->where('id', $firstId)->update([
                    'artist_category_ids' => json_encode($categoryIds)
                ]);

                // Delete the other entries
                if (!empty($otherIds)) {
                    DB::table($table)->whereIn('id', $otherIds)->delete();
                }
            }

            // 3. Drop old columns
            if (Schema::hasColumn($table, 'artist_category_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['artist_category_id']);
                    $table->dropColumn(['artist_category_id', 'role']);
                });
            }

            // Note: Unique index check is harder, but we can try-catch or just check if it exists
            try {
                Schema::table($table, function (Blueprint $table) use ($foreignKey) {
                    $table->unique(['artist_id', $foreignKey], 'artist_' . $foreignKey . '_unique');
                });
            } catch (\Exception $e) {
                // Ignore if unique index already exists
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'artist_movie' => 'movie_id',
            'artist_song' => 'song_id',
            'artist_tvshow' => 'tvshow_id',
        ];

        foreach ($tables as $table => $foreignKey) {
            Schema::table($table, function (Blueprint $table) use ($foreignKey) {
                $table->unsignedBigInteger('artist_category_id')->nullable()->after('artist_id');
                $table->string('role')->nullable()->after('artist_category_id');
                $table->dropUnique('artist_' . $foreignKey . '_unique');
            });

            // Migrate back: we can only set one category back, take the first one
            $entries = DB::table($table)->get();
            foreach ($entries as $entry) {
                $ids = json_decode($entry->artist_category_ids, true);
                if (!empty($ids)) {
                    DB::table($table)->where('id', $entry->id)->update([
                        'artist_category_id' => $ids[0]
                    ]);
                }
            }

            Schema::table($table, function (Blueprint $table) {
                $table->foreign('artist_category_id')->references('id')->on('artist_category')->onDelete('cascade');
                $table->dropColumn('artist_category_ids');
            });
        }
    }
};
