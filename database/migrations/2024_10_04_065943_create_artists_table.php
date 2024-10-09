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
        Schema::disableForeignKeyConstraints();

        Schema::create('artists', function (Blueprint $table) {
            $table->integer('id')->primary()->autoIncrement();
            $table->string('name', 255);
            $table->text('bio')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('country', 255)->nullable();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
    }
};
