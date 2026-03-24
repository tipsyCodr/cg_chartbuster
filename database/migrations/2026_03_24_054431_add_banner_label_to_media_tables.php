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
        if (!Schema::hasColumn('movies', 'banner_label')) {
            Schema::table('movies', function (Blueprint $table) {
                $table->string('banner_label')->nullable()->after('show_on_banner');
            });
        }

        if (!Schema::hasColumn('songs', 'banner_label')) {
            Schema::table('songs', function (Blueprint $table) {
                $table->string('banner_label')->nullable()->after('show_on_banner');
            });
        }

        if (!Schema::hasColumn('tvshows', 'banner_label')) {
            Schema::table('tvshows', function (Blueprint $table) {
                $table->string('banner_label')->nullable()->after('show_on_banner');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('movies', 'banner_label')) {
            Schema::table('movies', function (Blueprint $table) {
                $table->dropColumn('banner_label');
            });
        }

        if (Schema::hasColumn('songs', 'banner_label')) {
            Schema::table('songs', function (Blueprint $table) {
                $table->dropColumn('banner_label');
            });
        }

        if (Schema::hasColumn('tvshows', 'banner_label')) {
            Schema::table('tvshows', function (Blueprint $table) {
                $table->dropColumn('banner_label');
            });
        }
    }
};
