<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $lang = $this->resolveLanguage($request);
        $selectedCategory = trim((string) $request->query('category', ''));
        $selectedTag = trim((string) $request->query('tag', ''));

        $query = Article::with('author')
            ->published();

        if ($selectedCategory !== '') {
            $query->where('category', $selectedCategory);
        }

        if ($selectedTag !== '') {
            $query->whereJsonContains('tags', $selectedTag);
        }

        $articles = $query
            ->latest('published_at')
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        $availableCategories = Article::published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $availableTags = Article::published()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatten()
            ->filter(fn ($tag) => is_string($tag) && trim($tag) !== '')
            ->map(fn ($tag) => trim($tag))
            ->unique()
            ->sort()
            ->values();

        return view('pages.articles.index', compact(
            'articles',
            'lang',
            'selectedCategory',
            'selectedTag',
            'availableCategories',
            'availableTags'
        ));
    }

    public function show(Request $request, string $slug)
    {
        $lang = $this->resolveLanguage($request);

        $article = Article::with('author')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $title = $article->localizedTitle($lang);
        $excerpt = $article->localizedExcerpt($lang) ?: Str::limit(strip_tags($article->localizedContent($lang)), 160);
        $metaTitle = $article->meta_title ?: $title . ' - CG Chartbusters';
        $metaDescription = $article->meta_description ?: Str::limit(strip_tags($excerpt), 160);
        $metaImage = $article->featured_image ? asset('storage/' . $article->featured_image) : asset('images/logo.png');

        return view('pages.articles.view', compact(
            'article',
            'lang',
            'title',
            'excerpt',
            'metaTitle',
            'metaDescription',
            'metaImage'
        ));
    }

    private function resolveLanguage(Request $request): string
    {
        $lang = $request->query('lang', 'hi');
        return in_array($lang, ['hi', 'en', 'chh'], true) ? $lang : 'hi';
    }
}
