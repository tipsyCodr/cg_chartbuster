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
        Schema::table('movies', function (Blueprint $table) {
            $table->text('content_description_chh')->nullable()->after('content_description');
        });

        Schema::table('tvshows', function (Blueprint $table) {
            $table->text('content_description_chh')->nullable()->after('content_description');
        });

        Schema::table('songs', function (Blueprint $table) {
            $table->text('content_description_chh')->nullable()->after('content_description');
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->text('bio_chh')->nullable()->after('bio_hi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('content_description_chh');
        });

        Schema::table('tvshows', function (Blueprint $table) {
            $table->dropColumn('content_description_chh');
        });

        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('content_description_chh');
        });

        Schema::table('artists', function (Blueprint $table) {
            $table->dropColumn('bio_chh');
        });
    }
};
