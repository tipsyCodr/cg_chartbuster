<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:article_categories,name',
        ]);

        $category = ArticleCategory::create($validated);

        return response()->json([
            'success' => true,
            'category' => $category,
        ]);
    }
}
