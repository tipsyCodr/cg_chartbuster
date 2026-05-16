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
        Schema::create('content_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('content_type');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('media_file')->nullable();
            $table->string('external_link')->nullable();
            $table->string('category')->nullable();
            $table->string('tags')->nullable();
            $table->json('payload_json')->nullable();
            $table->boolean('terms_accepted')->default(false);
            $table->string('moderation_status')->default('submitted'); // submitted, under_review, approved, rejected
            $table->text('admin_notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_submissions');
    }
};
