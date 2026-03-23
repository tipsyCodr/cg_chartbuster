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
        $tables = ['artist_movie', 'artist_song', 'artist_tvshow'];

        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $value = $row->artist_category_ids;
                
                // If the value is a string and starts with an escaped quote, it's likely double-encoded.
                // e.g., in DB it looks like: "\"[\"14\"]\""
                if (is_string($value) && str_starts_with($value, '"')) {
                    $decoded = json_decode($value);
                    if (is_string($decoded)) {
                        DB::table($table)->where('id', $row->id)->update([
                            'artist_category_ids' => $decoded
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No simple way to safely reverse this without knowing the previous state,
        // but since it's a data fix, it's generally safe to leave as-is.
    }
};
