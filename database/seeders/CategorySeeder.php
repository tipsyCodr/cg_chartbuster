<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    $categories = [
        'Director',
        'Cinematographer',
        'DOP',
        'Screen Play',
        'Writer / Story / Concept',
        'Actor',
        'Actress',
        'Support Artists',
        'Producer',
        'Singer (Male)',
        'Singer (Female)',
        'Lyricist',
        'Composer',
        'Mix Master',
        'Music Director',
        'Recordists',
        'Audio Studio',
        'Editor',
        'Video Studio',
        'Poster/Logo',
        'VFX',
        'Make up',
        'Drone',
        'Others'
    ];

    foreach ($categories as $category) {
        DB::table('artist_category')->insert([
            'name' => $category,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    }
}
