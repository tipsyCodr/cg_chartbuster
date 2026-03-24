<x-app-layout>
    <section class="mt-8 min-h-[50vh]">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold">Articles</h1>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-300">Language:</span>
                <div class="flex rounded-full border border-gray-700 bg-gray-900 p-1">
                    <a href="{{ route('articles.index', ['lang' => 'hi', 'category' => $selectedCategory ?: null, 'tag' => $selectedTag ?: null]) }}"
                        class="px-3 py-1 text-xs font-bold rounded-full {{ $lang === 'hi' ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">हिंदी</a>
                    <a href="{{ route('articles.index', ['lang' => 'en', 'category' => $selectedCategory ?: null, 'tag' => $selectedTag ?: null]) }}"
                        class="px-3 py-1 text-xs font-bold rounded-full {{ $lang === 'en' ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">EN</a>
                    <a href="{{ route('articles.index', ['lang' => 'chh', 'category' => $selectedCategory ?: null, 'tag' => $selectedTag ?: null]) }}"
                        class="px-3 py-1 text-xs font-bold rounded-full {{ $lang === 'chh' ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">छग</a>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('articles.index') }}" class="mt-5 rounded-xl border border-gray-700 bg-gray-900/50 p-5">
            <input type="hidden" name="lang" value="{{ $lang }}">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div>
                    <label for="category" class="text-xs font-semibold uppercase tracking-wide text-gray-400">Category</label>
                    <select id="category" name="category" class="mt-2 h-12 w-full rounded-lg border-gray-700 bg-gray-900 px-3 text-gray-100">
                        <option value="">All Categories</option>
                        @foreach($availableCategories as $category)
                            <option value="{{ $category }}" {{ $selectedCategory === $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tag" class="text-xs font-semibold uppercase tracking-wide text-gray-400">Tag</label>
                    <select id="tag" name="tag" class="mt-2 h-12 w-full rounded-lg border-gray-700 bg-gray-900 px-3 text-gray-100">
                        <option value="">All Tags</option>
                        @foreach($availableTags as $tag)
                            <option value="{{ $tag }}" {{ $selectedTag === $tag ? 'selected' : '' }}>#{{ $tag }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="h-12 rounded-lg bg-yellow-500 px-5 text-sm font-bold text-black hover:bg-yellow-400">Apply</button>
                    <a href="{{ route('articles.index', ['lang' => $lang]) }}" class="inline-flex h-12 items-center rounded-lg border border-gray-600 px-5 text-sm font-semibold text-gray-200 hover:bg-gray-800">Clear</a>
                </div>
            </div>
        </form>

        <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                @php
                    $title = $article->localizedTitle($lang);
                    $excerpt = $article->localizedExcerpt($lang) ?: \Illuminate\Support\Str::limit(strip_tags($article->localizedContent($lang)), 130);
                    $articleTags = collect($article->tags ?? [])->take(3);
                @endphp
                <article class="overflow-hidden rounded-xl border border-gray-700 bg-gray-900/60">
                    <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => $lang]) }}">
                        <div class="h-44 w-full bg-gray-800">
                            @if($article->featured_image)
                                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $title }}"
                                    class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-sm text-gray-400">No Thumbnail</div>
                            @endif
                        </div>
                    </a>
                    <div class="space-y-2 p-4">
                        <h2 class="line-clamp-2 text-xl font-semibold text-white">
                            <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => $lang]) }}" class="hover:text-yellow-400">
                                {{ $title }}
                            </a>
                        </h2>
                        <p class="line-clamp-3 text-sm text-gray-300">{{ $excerpt }}</p>
                        <div class="flex flex-wrap items-center gap-2 text-xs">
                            @if(!empty($article->category))
                                <a href="{{ route('articles.index', ['lang' => $lang, 'category' => $article->category]) }}"
                                    class="rounded-full border border-gray-600 px-2 py-1 text-gray-300 hover:border-yellow-400 hover:text-yellow-300">
                                    {{ $article->category }}
                                </a>
                            @endif
                            @foreach($articleTags as $tag)
                                <a href="{{ route('articles.index', ['lang' => $lang, 'tag' => $tag]) }}"
                                    class="rounded-full bg-gray-800 px-2 py-1 text-gray-300 hover:bg-gray-700">
                                    #{{ $tag }}
                                </a>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <span>{{ optional($article->published_at ?? $article->created_at)->format('d M Y') }}</span>
                            <span>{{ $article->author?->name ?? 'CG Chartbusters' }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-gray-400">No published articles yet.</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $articles->links() }}</div>
    </section>
</x-app-layout>
