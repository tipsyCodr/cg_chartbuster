<x-app-layout>
    <section class="mt-8 min-h-[50vh]">
        <!-- Editorial Header -->
        <div class="mb-16">
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between border-b-2 border-white/5 pb-10">
                <div>
                    <div class="inline-block px-3 py-1 bg-yellow-400 text-black text-[10px] font-black uppercase tracking-[0.2em] mb-4 rounded">The Daily Digest</div>
                    <h1 class="text-6xl md:text-8xl font-black text-white tracking-tighter uppercase leading-[0.85]">
                        CHHOLLYWOOD <br><span class="text-yellow-400">INSIGHTS</span>
                    </h1>
                    <p class="mt-6 text-sm font-bold text-gray-400 uppercase tracking-[0.4em] max-w-xl">Deep Dives into Chhattisgarh's Cinema, Culture & Celebrities</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="hidden md:block text-right">
                        <div class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Current Edition</div>
                        <div class="text-sm font-bold text-white uppercase tracking-wider">{{ now()->format('F d, Y') }}</div>
                    </div>
                    <div class="h-12 w-[1px] bg-white/10 hidden md:block"></div>
                    <div class="flex items-center gap-2 bg-white/5 p-1.5 rounded-xl border border-white/10">
                    <span class="pl-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Edition:</span>
                    <div class="flex rounded-xl bg-black/40 p-1">
                        @foreach(['hi' => 'हिंदी', 'en' => 'EN', 'chh' => 'छग'] as $code => $label)
                            <a href="{{ route('articles.index', ['lang' => $code, 'category' => $selectedCategory ?: null, 'tag' => $selectedTag ?: null]) }}"
                                class="px-4 py-1.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ $lang === $code ? 'bg-yellow-400 text-black shadow-lg shadow-yellow-400/20' : 'text-gray-400 hover:text-white' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>

        @if($articles->onFirstPage() && !$selectedCategory && !$selectedTag && $articles->count() > 0)
            @php $featured = $articles->first(); @endphp
            <!-- Featured Hero Article -->
            <div class="relative group cursor-pointer overflow-hidden rounded-[40px] border border-white/5 mb-20 shadow-2xl bg-black">
                <a href="{{ route('articles.show', ['slug' => $featured->slug, 'lang' => $lang]) }}" class="grid grid-cols-1 md:grid-cols-12 min-h-[550px]">
                    <div class="md:col-span-7 relative overflow-hidden order-1 md:order-2">
                        <img src="{{ $featured->featured_image ? asset('storage/' . $featured->featured_image) : asset('images/logo.png') }}" 
                             class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105" alt="{{ $featured->localizedTitle($lang) }}">
                        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/20 to-transparent"></div>
                    </div>
                    
                    <div class="md:col-span-12 lg:col-span-5 absolute inset-0 md:relative p-10 md:p-16 flex flex-col justify-center bg-black/40 md:bg-transparent backdrop-blur-sm md:backdrop-blur-0 z-10 order-2 md:order-1">
                        @if($featured->category)
                            <div class="mb-8">
                                <span class="px-4 py-1.5 rounded-full bg-yellow-400 text-black text-[10px] font-black uppercase tracking-[0.2em]">
                                    {{ $featured->category->name }}
                                </span>
                            </div>
                        @endif
                        <h2 class="text-4xl md:text-6xl font-black text-white tracking-tighter leading-[0.95] mb-8 group-hover:text-yellow-400 transition-colors">
                            {{ $featured->localizedTitle($lang) }}
                        </h2>
                        <p class="text-gray-300 text-base md:text-lg font-medium line-clamp-3 max-w-xl opacity-90 leading-relaxed mb-10">
                            {{ $featured->localizedExcerpt($lang) ?: \Illuminate\Support\Str::limit(strip_tags($featured->localizedContent($lang)), 200) }}
                        </p>
                        <div class="pt-8 border-t border-white/10 flex items-center gap-6 text-[10px] font-black text-gray-500 uppercase tracking-widest">
                            <span class="flex items-center text-yellow-400"><i class="far fa-user mr-2"></i>{{ $featured->author?->name ?? 'CG Staff' }}</span>
                            <span class="w-1 h-1 rounded-full bg-gray-700"></span>
                            <span class="flex items-center"><i class="far fa-clock mr-2"></i>{{ optional($featured->published_at ?? $featured->created_at)->format('M d, Y') }}</span>
                            <span class="hidden lg:inline-flex items-center gap-2 group-hover:translate-x-2 transition-transform">
                                <span class="text-white">Read More</span>
                                <i class="fas fa-arrow-right text-yellow-500"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        @endif

        <!-- Filter Navigation -->
        <div class="sticky top-24 z-40 mb-12">
            <form method="GET" action="{{ route('articles.index') }}" class="flex flex-col md:flex-row gap-4 items-center bg-gray-900/80 backdrop-blur-xl p-4 rounded-[32px] border border-white/5 shadow-2xl">
                <input type="hidden" name="lang" value="{{ $lang }}">
                
                <div class="flex-1 flex gap-2 w-full overflow-x-auto no-scrollbar pb-1 md:pb-0">
                    <a href="{{ route('articles.index', ['lang' => $lang]) }}" 
                       class="whitespace-nowrap px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ !$selectedCategory ? 'bg-white text-black shadow-lg shadow-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        All Stories
                    </a>
                    @foreach($availableCategories as $category)
                        <a href="{{ route('articles.index', ['lang' => $lang, 'category' => $category->slug]) }}" 
                           class="whitespace-nowrap px-6 py-2.5 rounded-2xl text-xs font-black uppercase tracking-widest transition-all {{ $selectedCategory === $category->slug ? 'bg-white text-black shadow-lg shadow-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto border-t md:border-t-0 md:border-l border-white/10 pt-4 md:pt-0 md:pl-4">
                    <select name="tag" onchange="this.form.submit()" class="bg-transparent border-none text-xs font-black uppercase tracking-widest text-gray-400 focus:ring-0 cursor-pointer hover:text-white transition-colors">
                        <option value="">Filter by Tag</option>
                        @foreach($availableTags as $tag)
                            <option value="{{ $tag }}" {{ $selectedTag === $tag ? 'selected' : '' }}>#{{ $tag }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse ($articles->onFirstPage() && !$selectedCategory && !$selectedTag ? $articles->skip(1) : $articles as $article)
                @php
                    $title = $article->localizedTitle($lang);
                    $excerpt = $article->localizedExcerpt($lang) ?: \Illuminate\Support\Str::limit(strip_tags($article->localizedContent($lang)), 150);
                    $articleTags = collect($article->tags ?? [])->take(2);
                @endphp
                <article class="group flex flex-col transition-all duration-500">
                    <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => $lang]) }}" class="relative aspect-[16/10] overflow-hidden rounded-[24px] mb-6">
                        <img src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('images/logo.png') }}" 
                             alt="{{ $title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @if($article->category)
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-yellow-400 text-black text-[9px] font-black uppercase tracking-widest rounded-full">
                                    {{ $article->category->name }}
                                </span>
                            </div>
                        @endif
                    </a>
                    
                    <div class="flex-1 flex flex-col">
                        <div class="flex items-center gap-3 text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-4">
                            <span>{{ optional($article->published_at ?? $article->created_at)->format('M d, Y') }}</span>
                            <span class="w-1 h-1 rounded-full bg-gray-800"></span>
                            <span class="text-yellow-500/80">{{ $article->author?->name ?? 'Staff' }}</span>
                        </div>
                        
                        <h3 class="text-2xl font-black text-white tracking-tight leading-[1.1] mb-4 group-hover:text-yellow-400 transition-colors line-clamp-2">
                            <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => $lang]) }}">
                                {{ $title }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3 font-medium opacity-80 group-hover:opacity-100 transition-opacity">
                            {{ $excerpt }}
                        </p>
                        
                        <div class="mt-auto pt-6 border-t border-white/5 flex items-center justify-between">
                            <div class="flex gap-3">
                                @foreach($articleTags as $tag)
                                    <span class="text-[9px] font-black uppercase text-gray-600 tracking-widest">#{{ $tag }}</span>
                                @endforeach
                            </div>
                            <a href="{{ route('articles.show', ['slug' => $article->slug, 'lang' => $lang]) }}" 
                               class="text-[10px] font-black text-white hover:text-yellow-400 transition-colors flex items-center gap-2 group/btn uppercase tracking-widest">
                                Read Story 
                                <i class="fas fa-chevron-right text-[8px] transition-transform group-hover/btn:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-32 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-white/5 text-gray-700 mb-8">
                        <i class="fas fa-feather-alt text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-white uppercase tracking-widest mb-2">Nothing to report</h3>
                    <p class="text-gray-500 font-bold uppercase tracking-[0.2em]">Our writers are hard at work. check back soon.</p>
                </div>
            @endforelse
        </div>

        @if($articles->hasPages())
            <div class="mt-24 pt-12 border-t border-white/5">
                {{ $articles->links() }}
            </div>
        @endif
    </section>
</x-app-layout>
