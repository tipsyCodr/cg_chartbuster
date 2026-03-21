<?php
use Illuminate\Support\Facades\DB;

foreach(['movies', 'songs', 'tvshows'] as $table) {
    try {
        $non_numeric = DB::table($table)
            ->whereNotNull('genre')
            ->get(['id', 'genre'])
            ->filter(fn($row) => !is_numeric($row->genre));
        
        echo "Table: $table | Non-numeric count: " . $non_numeric->count() . "\n";
        if ($non_numeric->count() > 0) {
            echo "Samples: " . $non_numeric->take(5)->map(fn($r) => $r->genre)->toJson() . "\n";
        }
    } catch (\Exception $e) {
        echo "Table: $table | Error: " . $e->getMessage() . "\n";
    }
}
