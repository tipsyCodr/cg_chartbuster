<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tvshow_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Core content fields (mirrors tvshows table)
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('release_date')->nullable();
            $table->string('director')->nullable();
            $table->string('poster_image')->nullable();
            $table->string('poster_image_portrait')->nullable();
            $table->string('poster_image_landscape')->nullable();
            $table->string('poster_logo')->nullable();
            $table->text('trailer_url')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->string('cbfc')->nullable();
            $table->integer('cg_chartbusters_ratings')->nullable();
            $table->string('cinematographer')->nullable();
            $table->string('dop')->nullable();
            $table->string('screen_play')->nullable();
            $table->string('writer_story_concept')->nullable();
            $table->string('male_lead')->nullable();
            $table->string('female_lead')->nullable();
            $table->string('support_artists')->nullable();
            $table->string('production_banner')->nullable();
            $table->string('producer')->nullable();
            $table->string('songs')->nullable();
            $table->string('singer_male')->nullable();
            $table->string('singer_female')->nullable();
            $table->string('lyrics')->nullable();
            $table->string('composition')->nullable();
            $table->string('mix_master')->nullable();
            $table->string('music')->nullable();
            $table->string('recordists')->nullable();
            $table->string('audio_studio')->nullable();
            $table->string('editor')->nullable();
            $table->string('video_studio')->nullable();
            $table->string('vfx')->nullable();
            $table->string('make_up')->nullable();
            $table->string('drone')->nullable();
            $table->string('others')->nullable();
            $table->text('content_description')->nullable();
            $table->text('content_description_chh')->nullable();
            $table->text('hyperlinks_links')->nullable();
            $table->boolean('is_release_year_only')->default(false);
            $table->boolean('show_on_banner')->default(false);
            $table->string('banner_label')->nullable();
            $table->string('banner_link')->nullable();
            $table->unsignedBigInteger('production_house_id')->nullable();

            // Relationship data stored as JSON
            $table->json('genre_ids')->nullable();
            $table->json('artists_json')->nullable();

            // Moderation fields
            $table->string('status')->default('pending');
            $table->text('review_notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('rejected_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tvshow_submissions');
    }
};
