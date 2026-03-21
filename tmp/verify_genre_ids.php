<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

foreach(['movies','songs','tvshows'] as $table) {
    if (!Schema::hasTable($table)) continue;
    $missing = DB::table($table)->whereNotNull('genre_id')->get()->filter(function($row) {
        return !DB::table('genres')->where('id', $row->genre_id)->exists();
    });
    if($missing->count() > 0) {
        echo "$table has missing genre IDs: " . $missing->pluck('genre_id')->unique()->implode(', ') . "\n";
    } else {
        echo "$table: all genre IDs are valid.\n";
    }
}
