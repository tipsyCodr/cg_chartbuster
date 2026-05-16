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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('event_type');
            $table->string('event_mode'); // e.g., online, offline, hybrid
            $table->string('venue')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('organizer_name');
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->text('description');
            $table->string('registration_link')->nullable();
            $table->string('entry_fee')->default('Free');
            $table->string('poster')->nullable();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->dateTime('registration_deadline')->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            $table->softDeletes();

            $table->index('approval_status');
            $table->index('start_datetime');
            $table->index(['city', 'event_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
