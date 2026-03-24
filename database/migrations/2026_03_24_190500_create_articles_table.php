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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('title_hi');
            $table->string('title_en')->nullable();
            $table->string('title_chh')->nullable();
            $table->text('excerpt_hi')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->text('excerpt_chh')->nullable();
            $table->longText('content_hi');
            $table->longText('content_en')->nullable();
            $table->longText('content_chh')->nullable();
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
