<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artist_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Core content fields (mirrors artists table)
            $table->string('name');
            $table->text('bio')->nullable();
            $table->text('bio_hi')->nullable();
            $table->text('bio_chh')->nullable();
            $table->decimal('cgcb_rating', 3, 1)->nullable();
            $table->json('category')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('photo')->nullable(); // nullable for user submissions
            $table->string('banner_image')->nullable();
            $table->string('city')->nullable();
            $table->text('hyperlinks_links')->nullable();
            $table->boolean('is_release_year_only')->default(false);
            $table->integer('founded_year')->nullable();
            $table->string('owner_name')->nullable();
            $table->integer('active_since')->nullable();
            $table->string('website_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_verified')->default(false);

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
        Schema::dropIfExists('artist_submissions');
    }
};
