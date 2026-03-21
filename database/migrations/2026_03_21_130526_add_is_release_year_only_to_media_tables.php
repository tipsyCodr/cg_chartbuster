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
        $tables = [
            'movies' => 'release_date',
            'songs' => 'release_date',
            'tvshows' => 'release_date',
            'artists' => 'birth_date' // wait, artist uses birth_date or debut_date? The model says birth_date! Wait, artists.blade.php says debut_date. Let's just put it without `after()`.
        ];
        foreach ($tables as $t => $col) {
            if (!Schema::hasColumn($t, 'is_release_year_only')) {
                Schema::table($t, function (Blueprint $table) {
                    $table->boolean('is_release_year_only')->default(false);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['movies', 'songs', 'tvshows', 'artists'];
        foreach ($tables as $t) {
            if (Schema::hasColumn($t, 'is_release_year_only')) {
                Schema::table($t, function (Blueprint $table) {
                    $table->dropColumn('is_release_year_only');
                });
            }
        }
    }
};
