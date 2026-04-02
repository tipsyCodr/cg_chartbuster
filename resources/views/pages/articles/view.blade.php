<x-app-layout>
    @section('meta_title', $metaTitle)
    @section('meta_description', $metaDescription)
    @section('meta_image', $metaImage)
    @section('og_type', 'article')

    @php
        $tags = collect($article->tags ?? [])->filter();
        $content = $article->localizedContent($lang);
    @endphp

    <div class="mt-8 pb-20">
        <!-- Breadcrumb & Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="flex flex-wrap items-center justify-between gap-6 mb-8 border-b border-white/10 pb-6">
                <nav class="flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">
                    <a href="{{ route('home') }}" class="hover:text-yellow-400 transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('articles.index', ['lang' => $lang]) }}" class="hover:text-yellow-400 transition-colors">Articles</a>
                    @if($article->category)
                        <span>/</span>
                        <a href="{{ route('articles.index', ['lang' => $lang, 'category' => $article->category->slug]) }}" class="text-yellow-400 hover:text-yellow-300 transition-colors">
                            {{ $article->category->name }}
                        </a>
                    @endif
                </nav>
                
                <div class="flex items-center gap-4 bg-white/5 p-1.5 rounded-xl border border-white/5">
                    <span class="pl-2 text-[9px] font-black text-gray-500 uppercase tracking-widest">Read in:</span>
                    <div class="flex rounded-lg bg-black/40 p-0.5">
                        <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => 'hi']) }}"
                            class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-md {{ $lang === 'hi' ? 'bg-yellow-400 text-black' : 'text-gray-500 hover:text-white' }}">हिंदी</a>
                        <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => 'en']) }}"
                            class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-md {{ $lang === 'en' ? 'bg-yellow-400 text-black' : 'text-gray-500 hover:text-white' }}">EN</a>
                        <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => 'chh']) }}"
                            class="px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-md {{ $lang === 'chh' ? 'bg-yellow-400 text-black' : 'text-gray-500 hover:text-white' }}">छग</a>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <span class="px-3 py-1 bg-yellow-400 text-black text-[10px] font-black uppercase tracking-[0.2em] rounded">Editorial Deep Dive</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tighter leading-[0.9] mb-10">
                {{ $title }}
            </h1>

            <div class="flex flex-wrap items-center gap-8 py-6 border-y border-white/5">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center text-black font-black text-xs mr-3">
                        {{ strtoupper(substr($article->author?->name ?? 'C', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-0.5">Reported By</p>
                        <p class="text-xs font-bold text-white">{{ $article->author?->name ?? 'CG Chartbusters Staff' }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-0.5">Published On</p>
                    <p class="text-xs font-bold text-white">{{ optional($article->published_at ?? $article->created_at)->format('F d, Y') }}</p>
                </div>
                <div class="hidden sm:block h-8 w-px bg-white/10"></div>
                <div class="flex items-center gap-3">
                    <x-social-share :url="url()->current()" :title="$title" :showInstagram="false" />
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-16">
                <!-- Main Content Column -->
                <article class="flex-1 min-w-0">
                    @if($article->featured_image)
                        <div class="relative overflow-hidden rounded-[40px] border border-white/10 mb-12 shadow-2xl group">
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $title }}" 
                                 class="w-full h-auto max-h-[600px] object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                    @endif

                    <div class="prose prose-invert prose-yellow max-w-none 
                                prose-p:text-gray-300 prose-p:text-xl prose-p:leading-relaxed prose-p:mb-10 font-medium
                                prose-h2:text-4xl prose-h2:font-black prose-h2:tracking-tighter prose-h2:text-white prose-h2:mt-16 prose-h2:mb-8
                                prose-blockquote:border-yellow-400 prose-blockquote:bg-white/5 prose-blockquote:p-10 prose-blockquote:rounded-[40px] prose-blockquote:text-2xl prose-blockquote:font-black prose-blockquote:italic
                                prose-img:rounded-[40px] prose-img:border prose-img:border-white/5 shadow-2xl">
                        {!! $content !!}
                    </div>

                    @if($tags->isNotEmpty())
                        <div class="mt-16 pt-12 border-t border-white/5 flex flex-wrap gap-3">
                            @foreach($tags as $tag)
                                <a href="{{ route('articles.index', ['lang' => $lang, 'tag' => $tag]) }}"
                                   class="px-4 py-2 bg-white/5 border border-white/5 rounded-xl text-[10px] font-black text-gray-400 uppercase tracking-widest hover:bg-white hover:text-black transition-all">
                                    #{{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </article>

                <!-- Sidebar Column -->
                <aside class="w-full lg:w-[350px] space-y-12 shrink-0">
                    <!-- Related Content -->
                    @if($relatedArticles->isNotEmpty())
                        <div>
                            <h4 class="text-xs font-black text-yellow-400 uppercase tracking-[0.2em] mb-8 pb-4 border-b border-yellow-400/20">Related Insights</h4>
                            <div class="space-y-8">
                                @foreach($relatedArticles as $rel)
                                    <a href="{{ route('articles.show', ['slug' => $rel->slug, 'lang' => $lang]) }}" class="group block">
                                        <div class="relative overflow-hidden rounded-2xl aspect-video mb-4 border border-white/5 transition-colors group-hover:border-yellow-400/20">
                                            <img src="{{ $rel->featured_image ? asset('storage/' . $rel->featured_image) : asset('images/logo.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="">
                                        </div>
                                        <h5 class="text-sm font-black text-white line-clamp-2 leading-snug group-hover:text-yellow-400 transition-colors">
                                            {{ $rel->localizedTitle($lang) }}
                                        </h5>
                                        <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mt-2">
                                            {{ optional($rel->published_at ?? $rel->created_at)->format('d M Y') }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Latest Feed -->
                    @if($latestArticles->isNotEmpty())
                        <div>
                            <h4 class="text-xs font-black text-white uppercase tracking-[0.2em] mb-8 pb-4 border-b border-white/10">Latest Chhollywood Feed</h4>
                            <div class="space-y-6">
                                @foreach($latestArticles as $lat)
                                    <a href="{{ route('articles.show', ['slug' => $lat->slug, 'lang' => $lang]) }}" class="group flex gap-4">
                                        <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 border border-white/5 group-hover:border-yellow-400/20 transition-colors text-white">
                                            <img src="{{ $lat->featured_image ? asset('storage/' . $lat->featured_image) : asset('images/logo.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="">
                                        </div>
                                        <div>
                                            <h5 class="text-xs font-black text-gray-300 line-clamp-2 leading-tight group-hover:text-white transition-colors">
                                                {{ $lat->localizedTitle($lang) }}
                                            </h5>
                                            <span class="text-[8px] font-black text-gray-600 uppercase tracking-widest mt-1 block">
                                                {{ optional($lat->published_at ?? $lat->created_at)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Promo/CTA -->
                    <div class="p-8 bg-yellow-400 rounded-[32px] overflow-hidden relative group">
                        <div class="absolute top-0 right-0 p-4 opacity-10 rotate-12 group-hover:rotate-0 transition-transform">
                            <i class="fas fa-star text-4xl"></i>
                        </div>
                        <p class="text-[10px] font-black text-black uppercase tracking-[0.2em] mb-2 font-black">Stay Connected</p>
                        <h4 class="text-lg font-black text-black leading-tight mb-6">Join the community & rate Chhollywood.</h4>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-black text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-900 transition-colors">
                            Join Now
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
