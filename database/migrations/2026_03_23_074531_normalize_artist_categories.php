<?php

use App\Models\Artist;
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
        // We use the model to leverage the 'array' cast we just added
        foreach (Artist::all() as $artist) {
            $raw = $artist->getAttributes()['category'] ?? null;
            
            if (empty($raw)) {
                $artist->category = [];
                $artist->save();
                continue;
            }

            // Check if it's already a valid JSON array
            $decoded = json_decode($raw, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                // It's likely a single ID string (e.g. "6")
                $artist->category = [$raw];
                $artist->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Normalization is generally one-way when moving to a more flexible format
    }
};
