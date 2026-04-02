<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('content_chh')->constrained('article_categories')->nullOnDelete();
        });

        // Migrate data
        $categories = DB::table('articles')->whereNotNull('category')->distinct()->pluck('category');
        foreach ($categories as $categoryName) {
            $slug = Str::slug($categoryName);
            // Ensure unique slug
            $originalSlug = $slug;
            $count = 1;
            while (DB::table('article_categories')->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $categoryId = DB::table('article_categories')->insertGetId([
                'name' => $categoryName,
                'slug' => $slug,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('articles')->where('category', $categoryName)->update(['category_id' => $categoryId]);
        }

        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('category')->nullable()->after('content_chh');
        });

        // Optional: restore data from category_id
        $articles = DB::table('articles')->whereNotNull('category_id')->get();
        foreach ($articles as $article) {
            $categoryName = DB::table('article_categories')->where('id', $article->category_id)->value('name');
            if ($categoryName) {
                DB::table('articles')->where('id', $article->id)->update(['category' => $categoryName]);
            }
        }

        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
