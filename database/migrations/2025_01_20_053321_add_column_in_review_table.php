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
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('tvshow_id')->after('user_id')->nullable();
            $table->unsignedBigInteger('album_id')->after('user_id')->nullable();
            $table->unsignedBigInteger('song_id')->after('user_id')->nullable();
            $table->unsignedBigInteger('movie_id')->after('user_id')->nullable()->change();
            $table->integer('flagged')->after('user_id')->nullable();
            $table->integer('banned')->after('user_id')->nullable();
            $table->integer('removed')->after('user_id')->nullable();
            $table->decimal('rating', 3, 1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            //
            $table->dropColumn(['tvshow_id',
                                'album_id',
                                'song_id',
                                'flagged',
                                'banned',
                                'removed']);
            $table->decimal('rating', 2, 1)->change();
        });
    }
};
