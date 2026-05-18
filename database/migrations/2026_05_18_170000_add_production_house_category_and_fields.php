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
        // 1. Insert "Production House" Category if not exists
        $exists = DB::table('artist_category')->where('slug', 'production-house')->exists();
        if (!$exists) {
            DB::table('artist_category')->insert([
                'name' => 'Production House',
                'slug' => 'production-house',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Add columns to artists table if they don't exist
        Schema::table('artists', function (Blueprint $table) {
            if (!Schema::hasColumn('artists', 'banner_image')) {
                $table->string('banner_image')->nullable()->after('photo');
            }
            if (!Schema::hasColumn('artists', 'founded_year')) {
                $table->integer('founded_year')->nullable()->after('birth_date');
            }
            if (!Schema::hasColumn('artists', 'owner_name')) {
                $table->string('owner_name')->nullable()->after('founded_year');
            }
            if (!Schema::hasColumn('artists', 'active_since')) {
                $table->integer('active_since')->nullable()->after('owner_name');
            }
            if (!Schema::hasColumn('artists', 'website_url')) {
                $table->string('website_url')->nullable()->after('bio_chh');
            }
            if (!Schema::hasColumn('artists', 'youtube_url')) {
                $table->string('youtube_url')->nullable()->after('website_url');
            }
            if (!Schema::hasColumn('artists', 'instagram_url')) {
                $table->string('instagram_url')->nullable()->after('youtube_url');
            }
            if (!Schema::hasColumn('artists', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('instagram_url');
            }
            if (!Schema::hasColumn('artists', 'twitter_url')) {
                $table->string('twitter_url')->nullable()->after('facebook_url');
            }
            if (!Schema::hasColumn('artists', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('twitter_url');
            }
            if (!Schema::hasColumn('artists', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('is_featured');
            }
        });

        // 3. Add production_house_id to movies, songs, tvshows if they don't exist
        Schema::table('movies', function (Blueprint $table) {
            if (!Schema::hasColumn('movies', 'production_house_id')) {
                $table->foreignId('production_house_id')->nullable()->constrained('artists')->nullOnDelete();
            }
        });

        Schema::table('songs', function (Blueprint $table) {
            if (!Schema::hasColumn('songs', 'production_house_id')) {
                $table->foreignId('production_house_id')->nullable()->constrained('artists')->nullOnDelete();
            }
        });

        Schema::table('tvshows', function (Blueprint $table) {
            if (!Schema::hasColumn('tvshows', 'production_house_id')) {
                $table->foreignId('production_house_id')->nullable()->constrained('artists')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tvshows', function (Blueprint $table) {
            if (Schema::hasColumn('tvshows', 'production_house_id')) {
                $table->dropForeign(['production_house_id']);
                $table->dropColumn('production_house_id');
            }
        });

        Schema::table('songs', function (Blueprint $table) {
            if (Schema::hasColumn('songs', 'production_house_id')) {
                $table->dropForeign(['production_house_id']);
                $table->dropColumn('production_house_id');
            }
        });

        Schema::table('movies', function (Blueprint $table) {
            if (Schema::hasColumn('movies', 'production_house_id')) {
                $table->dropForeign(['production_house_id']);
                $table->dropColumn('production_house_id');
            }
        });

        Schema::table('artists', function (Blueprint $table) {
            $colsToDrop = [];
            foreach ([
                'banner_image',
                'founded_year',
                'owner_name',
                'active_since',
                'website_url',
                'youtube_url',
                'instagram_url',
                'facebook_url',
                'twitter_url',
                'is_featured',
                'is_verified'
            ] as $col) {
                if (Schema::hasColumn('artists', $col)) {
                    $colsToDrop[] = $col;
                }
            }
            if (!empty($colsToDrop)) {
                $table->dropColumn($colsToDrop);
            }
        });

        DB::table('artist_category')->where('slug', 'production-house')->delete();
    }
};
