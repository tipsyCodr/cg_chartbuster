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
            // $table->string('title', 255);
            $table->string('region', 255)->nullable();
            $table->string('cbfc', 255)->nullable();
            $table->integer('cg_chartbusters_ratings')->nullable();
            $table->integer('imdb_ratings')->nullable();
            $table->string('cinematographer', 255)->nullable();
            $table->string('dop', 255)->nullable();
            $table->string('screen_play', 255)->nullable();
            $table->string('writer_story_concept', 255)->nullable();
            $table->string('male_lead', 255)->nullable();
            $table->string('female_lead', 255)->nullable();
            $table->string('support_artists', 255)->nullable();
            $table->string('production_banner', 255)->nullable();
            $table->string('producer', 255)->nullable();
            $table->string('songs', 255)->nullable();
            $table->string('singer_male', 255)->nullable();
            $table->string('singer_female', 255)->nullable();
            $table->string('lyrics', 255)->nullable();
            $table->string('composition', 255)->nullable();
            $table->string('mix_master', 255)->nullable();
            $table->string('music', 255)->nullable();
            $table->string('recordists', 255)->nullable();
            $table->string('audio_studio', 255)->nullable();
            $table->string('editor', 255)->nullable();
            $table->string('video_studio', 255)->nullable();
            $table->string('poster_logo', 255)->nullable();
            $table->string('vfx', 255)->nullable();
            $table->string('make_up', 255)->nullable();
            $table->string('drone', 255)->nullable();
            $table->string('others', 255)->nullable();
            $table->text('content_description')->nullable();
            $table->string('hyperlinks_links', 255)->nullable();
            $table->string('poster_image_portrait', 255)->nullable();
            $table->string('poster_image_landscape', 255)->nullable();
        });   
        Schema::table('movies', function (Blueprint $table) {
            $table->time('duration')->change();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn([
            'region',
            'cbfc',
            'cg_chartbusters_ratings',
            'imdb_ratings',
            'cinematographer',
            'dop',
            'screen_play',
            'writer_story_concept',
            'male_lead',
            'female_lead',
            'support_artists',
            'production_banner',
            'producer',
            'songs',
            'singer_male',
            'singer_female',
            'lyrics',
            'composition',
            'mix_master',
            'music',
            'recordists',
            'audio_studio',
            'editor',
            'video_studio',
            'poster_logo',
            'vfx',
            'make_up',
            'drone',
            'others',
            'content_description',
            'hyperlinks_links',
            'poster_image_portrait',
            'poster_image_landscape'
            ]);
        });
        Schema::table('movies', function (Blueprint $table) {
            $table->integer('duration')->change();
        });
    }
};
