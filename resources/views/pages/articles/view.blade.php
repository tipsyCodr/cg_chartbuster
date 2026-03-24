<x-app-layout>
    @section('meta_title', $metaTitle)
    @section('meta_description', $metaDescription)
    @section('meta_image', $metaImage)
    @section('og_type', 'article')

    @php
        $tags = collect($article->tags ?? [])->filter();
        $content = $article->localizedContent($lang);
    @endphp

    <article class="mx-auto mt-8 max-w-4xl space-y-6 pb-10">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-300">Language:</span>
                <div class="flex rounded-full border border-gray-700 bg-gray-900 p-1">
                    <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => 'hi']) }}"
                        class="px-3 py-1 text-xs font-bold rounded-full {{ $lang === 'hi' ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">हिंदी</a>
                    <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => 'en']) }}"
                        class="px-3 py-1 text-xs font-bold rounded-full {{ $lang === 'en' ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">EN</a>
                    <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => 'chh']) }}"
                        class="px-3 py-1 text-xs font-bold rounded-full {{ $lang === 'chh' ? 'bg-yellow-500 text-black' : 'text-gray-300' }}">छग</a>
                </div>
            </div>
            <a href="{{ route('articles.index', ['lang' => $lang]) }}" class="text-sm text-yellow-400 hover:text-yellow-300">Back to Articles</a>
        </div>

        @if($article->featured_image)
            <div class="overflow-hidden rounded-xl border border-gray-700 bg-gray-900">
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $title }}" class="h-full w-full object-cover">
            </div>
        @endif

        <header class="space-y-3">
            <h1 class="text-3xl font-bold text-white md:text-4xl">{{ $title }}</h1>
            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-300">
                <span>By {{ $article->author?->name ?? 'CG Chartbusters' }}</span>
                <span>•</span>
                <span>{{ optional($article->published_at ?? $article->created_at)->format('d M Y') }}</span>
                @if(!empty($article->category))
                    <span>•</span>
                    <a href="{{ route('articles.index', ['lang' => $lang, 'category' => $article->category]) }}"
                        class="rounded-full border border-gray-700 px-2 py-0.5 text-xs hover:border-yellow-400 hover:text-yellow-300">
                        {{ $article->category }}
                    </a>
                @endif
            </div>
        </header>

        @if($tags->isNotEmpty())
            <section class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <a href="{{ route('articles.index', ['lang' => $lang, 'tag' => $tag]) }}"
                        class="rounded-full bg-gray-800 px-3 py-1 text-xs text-gray-200 hover:bg-gray-700">
                        #{{ $tag }}
                    </a>
                @endforeach
            </section>
        @endif

        <section class="prose prose-invert max-w-none rounded-xl border border-gray-700 bg-gray-900/50 p-5">
            {!! $content !!}
        </section>

        <x-social-share :url="url()->current()" :title="$title" :showInstagram="false" />
    </article>
</x-app-layout>
