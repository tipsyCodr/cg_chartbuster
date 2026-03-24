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
            $table->string('banner_link')->nullable()->after('banner_label');
        });
        Schema::table('songs', function (Blueprint $table) {
            $table->string('banner_link')->nullable()->after('banner_label');
        });
        Schema::table('tvshows', function (Blueprint $table) {
            $table->string('banner_link')->nullable()->after('banner_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('banner_link');
        });
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('banner_link');
        });
        Schema::table('tvshows', function (Blueprint $table) {
            $table->dropColumn('banner_link');
        });
    }
};
