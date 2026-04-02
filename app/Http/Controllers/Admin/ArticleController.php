<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->latest()->paginate(15);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = \App\Models\ArticleCategory::orderBy('name')->get();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $validated['user_id'] = auth()->id();
        $validated['tags'] = $this->parseTags($request->input('tags_input'));
        $validated['slug'] = filled($validated['slug'] ?? null) ? $validated['slug'] : null;
        $validated['published_at'] = $validated['status'] === 'published'
            ? ($validated['published_at'] ?? now())
            : null;

        unset($validated['tags_input']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        $categories = \App\Models\ArticleCategory::orderBy('name')->get();
        $tagsInput = implode(', ', \Illuminate\Support\Arr::wrap($article->tags));
        return view('admin.articles.edit', compact('article', 'tagsInput', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $this->validateRequest($request, $article->id);

        $validated['tags'] = $this->parseTags($request->input('tags_input'));
        $validated['slug'] = filled($validated['slug'] ?? null) ? $validated['slug'] : null;
        $validated['published_at'] = $validated['status'] === 'published'
            ? ($validated['published_at'] ?? $article->published_at ?? now())
            : null;

        unset($validated['tags_input']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('articles', 'public');
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }

    private function validateRequest(Request $request, ?int $articleId = null): array
    {
        return $request->validate([
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('articles', 'slug')->ignore($articleId),
            ],
            'title_hi' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'title_chh' => 'nullable|string|max:255',
            'excerpt_hi' => 'nullable|string',
            'excerpt_en' => 'nullable|string',
            'excerpt_chh' => 'nullable|string',
            'content_hi' => 'required|string',
            'content_en' => 'nullable|string',
            'content_chh' => 'nullable|string',
            'category_id' => 'nullable|exists:article_categories,id',
            'tags_input' => 'nullable|string',
            'featured_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,avif|max:102400',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
        ]);
    }

    private function parseTags(?string $tagsInput): array
    {
        if (empty($tagsInput)) {
            return [];
        }

        return collect(explode(',', $tagsInput))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
