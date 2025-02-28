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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->date('release_date')->nullable();
            $table->string('genre', 255)->nullable();
            $table->time('duration')->nullable();
            $table->string('director', 255)->nullable();
            $table->string('album')->nullable();
            $table->string('poster_image', 255)->nullable();
            $table->string('trailer_url', 255)->nullable();
            $table->string('region', 255)->nullable();
            $table->integer('cg_chartbusters_ratings')->nullable();
            $table->integer('imdb_ratings')->nullable();
            // $table->string('artists', 255)->nullable();
            $table->string('support_artists', 255)->nullable();
            $table->string('producer', 255)->nullable();
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
            $table->string('vfx', 255)->nullable();
            $table->string('make_up', 255)->nullable();
            $table->string('drone', 255)->nullable();
            $table->string('others', 255)->nullable();
            $table->text('content_description')->nullable();
            $table->string('hyperlinks_links', 255)->nullable();
            $table->string('poster_image_portrait', 255)->nullable();
            $table->string('poster_image_landscape', 255)->nullable();
            $table->timestamps();
        });
        Schema::create('tvshows', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->date('release_date')->nullable();
            $table->string('genre', 255)->nullable();
            $table->time('duration')->nullable();
            $table->string('director', 255)->nullable();
            $table->string('trailer_url', 255)->nullable();
            $table->string('album')->nullable();
            $table->string('poster_image', 255)->nullable();
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
        Schema::dropIfExists('tvshows');
    }
};
