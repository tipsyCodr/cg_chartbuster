<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Movies' => ['Crime', 'Romance', 'Comedy', 'Thriller', 'Horror', 'Sci-fi', 'Crime', 'Award-winning', 'Anime'],
            'Tv Shows' => ['Sci-fi', 'Romance', 'Comedy', 'Thriller', 'Horror', 'Sci-fi', 'Crime', 'Award-winning', 'Anime', 'Interviews'],
            'Songs' => ['Folk', 'Romance', 'Folk', 'Classical', 'Devotee', 'Dj & Fusion', 'Lofi', 'Award-winning']
        ];

        foreach ($genres as $category => $genreList) {
            foreach ($genreList as $genre) {
                DB::table('genres')->insert([
                    'for' => $category,
                    'name' => $genre,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
