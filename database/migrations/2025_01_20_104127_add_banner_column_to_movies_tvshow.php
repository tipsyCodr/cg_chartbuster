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
            //
            $table->boolean('show_on_banner')->default(false);
        });

        Schema::table('tvshows', function (Blueprint $table) {
            //
            $table->boolean('show_on_banner')->default(false);

        });
        Schema::table('albums', function (Blueprint $table) {
            //
            $table->boolean('show_on_banner')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            //
            $table->dropColumn('show_on_banner');
        });
        Schema::table('tvshows', function (Blueprint $table) {
            //
            $table->dropColumn('show_on_banner');
        });
        Schema::table('albums', function (Blueprint $table) {
            //
            $table->dropColumn('show_on_banner');

        });
    }
};
