<x-app-layout>
    @section('meta_title', $productionHouse->name . ' - Production House Profile - CG Chartbusters')
    @section('meta_description', \Illuminate\Support\Str::limit(strip_tags($productionHouse->bio ?? 'Explore ' . $productionHouse->name . '\'s produced movies, songs, and web series on CG Chartbusters.'), 160))
    @section('meta_image', $productionHouse->photo ? asset('storage/' . $productionHouse->photo) : ($productionHouse->banner_image ? asset('storage/' . $productionHouse->banner_image) : asset('images/placeholder.png')))
    @section('og_type', 'profile')

    <div class="w-full bg-gray-950 text-white min-h-screen">
        <!-- Hero Banner section -->
        <div class="relative w-full h-[240px] md:h-[400px] bg-gray-900 overflow-hidden">
            @if($productionHouse->banner_image)
                <img src="{{ asset('storage/' . $productionHouse->banner_image) }}" alt="{{ $productionHouse->name }} Banner" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-tr from-slate-900 via-purple-950 to-indigo-950 opacity-90"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-gray-955 via-gray-900/60 to-transparent"></div>
        </div>

        <div class="px-3 pb-16 sm:px-6 max-w-7xl mx-auto -mt-24 md:-mt-44 relative z-10">
            <!-- Header Profile Info Block -->
            <div class="bg-gray-900/80 backdrop-blur-xl rounded-3xl border border-gray-800/80 p-6 md:p-8 shadow-2xl mb-8">
                <div class="flex flex-col md:flex-row gap-6 md:gap-8 items-center md:items-start text-center md:text-left">
                    <!-- Logo / Photo -->
                    <div class="relative -mt-16 md:-mt-24">
                        <img class="h-32 w-32 md:h-44 md:w-44 rounded-2xl object-cover shadow-2xl border-4 border-gray-900 bg-gray-800 shrink-0 mx-auto"
                            src="{{ $productionHouse->photo ? asset('storage/' . $productionHouse->photo) : asset('images/placeholder.png') }}"
                            alt="{{ $productionHouse->name }}">
                        @if($productionHouse->is_verified)
                            <div class="absolute -bottom-2 -right-2 bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center border-4 border-gray-900 shadow-lg" title="Verified Production House">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-1 min-w-0 w-full">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                            <div>
                                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2.5">
                                    <h1 class="break-words text-2xl font-black text-white sm:text-3xl lg:text-4xl tracking-tight">{{ $productionHouse->name }}</h1>
                                    <span class="px-3 py-1 bg-yellow-500/10 text-yellow-500 text-[10px] font-black uppercase tracking-widest rounded-full border border-yellow-500/20">
                                        Production House
                                    </span>
                                    @if($productionHouse->is_featured)
                                        <span class="px-3 py-1 bg-purple-500/10 text-purple-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-purple-500/20">
                                            <i class="fas fa-crown mr-1"></i> Featured
                                        </span>
                                    @endif
                                </div>

                                <!-- Dynamic Statistics / Metadata tags -->
                                <div class="flex flex-wrap justify-center md:justify-start items-center gap-x-4 gap-y-2 mt-3 text-xs text-gray-400">
                                    @if($productionHouse->founded_year)
                                        <span class="flex items-center gap-1.5"><i class="far fa-calendar-alt text-yellow-500"></i> Founded in {{ $productionHouse->founded_year }}</span>
                                    @endif
                                    @if($productionHouse->owner_name)
                                        <span class="flex items-center gap-1.5"><i class="far fa-user text-yellow-500"></i> Owner: {{ $productionHouse->owner_name }}</span>
                                    @endif
                                    @if($productionHouse->active_since)
                                        <span class="flex items-center gap-1.5"><i class="fas fa-history text-yellow-500"></i> Active Since: {{ $productionHouse->active_since }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Rating Badges -->
                            <div class="flex items-center justify-center md:justify-start gap-4">
                                <div class="bg-gray-950/80 px-4 py-2 rounded-2xl border border-gray-800 text-center shadow-lg">
                                    <div class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-0.5">Rating</div>
                                    <div class="text-yellow-500 font-black text-lg flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-star text-sm"></i>
                                        <span>{{ $productionHouse->cgcb_rating ?? '0' }}/10</span>
                                    </div>
                                </div>
                                <div class="bg-gray-950/80 px-4 py-2 rounded-2xl border border-gray-800 text-center shadow-lg">
                                    <div class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-0.5">Reviews</div>
                                    <div class="text-white font-black text-lg">
                                        {{ $reviews->total() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description & Bio Block -->
                        <div class="mt-6 pt-6 border-t border-gray-850">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 gap-3">
                                <h3 class="text-xs uppercase tracking-wider font-bold text-gray-400">About the Production House</h3>
                                <x-language-switcher variant="compact" />
                            </div>
                            <div class="text-gray-300 leading-relaxed text-sm max-w-4xl whitespace-pre-line">
                                @if(app()->getLocale() == 'chh' && !empty($productionHouse->bio_chh))
                                    {!! nl2br(e($productionHouse->bio_chh)) !!}
                                @elseif(app()->getLocale() == 'hi' && !empty($productionHouse->bio_hi))
                                    {!! nl2br(e($productionHouse->bio_hi)) !!}
                                @else
                                    {!! nl2br(e($productionHouse->bio ?? 'No description available for this production house.')) !!}
                                @endif
                            </div>
                        </div>

                        <!-- Footer actions and Social Links -->
                        <div class="mt-6 pt-6 border-t border-gray-850 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <button onclick="document.getElementById('review-section').scrollIntoView({behavior:'smooth'})" 
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-500 text-black font-black rounded-xl hover:bg-yellow-600 transition-all shadow-xl active:scale-95 group">
                                    <i class="fa-solid fa-star transition-transform group-hover:rotate-12"></i>
                                    Rate Profile
                                </button>
                                <x-social-share :url="url()->current()" :title="$productionHouse->name" />
                            </div>

                            <!-- Social Links Buttons -->
                            <div class="flex items-center gap-2">
                                @if($productionHouse->website_url)
                                    <a href="{{ $productionHouse->website_url }}" target="_blank" class="w-10 h-10 rounded-xl bg-gray-850 text-gray-400 hover:text-white hover:bg-gray-800 transition-colors flex items-center justify-center border border-gray-800" title="Official Website">
                                        <i class="fas fa-globe"></i>
                                    </a>
                                @endif
                                @if($productionHouse->facebook_url)
                                    <a href="{{ $productionHouse->facebook_url }}" target="_blank" class="w-10 h-10 rounded-xl bg-gray-850 text-gray-400 hover:text-blue-500 hover:bg-gray-800 transition-colors flex items-center justify-center border border-gray-800" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                @endif
                                @if($productionHouse->instagram_url)
                                    <a href="{{ $productionHouse->instagram_url }}" target="_blank" class="w-10 h-10 rounded-xl bg-gray-850 text-gray-400 hover:text-pink-500 hover:bg-gray-800 transition-colors flex items-center justify-center border border-gray-800" title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if($productionHouse->twitter_url)
                                    <a href="{{ $productionHouse->twitter_url }}" target="_blank" class="w-10 h-10 rounded-xl bg-gray-850 text-gray-400 hover:text-sky-400 hover:bg-gray-800 transition-colors flex items-center justify-center border border-gray-800" title="Twitter / X">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                @endif
                                @if($productionHouse->youtube_url)
                                    <a href="{{ $productionHouse->youtube_url }}" target="_blank" class="w-10 h-10 rounded-xl bg-gray-850 text-gray-400 hover:text-red-500 hover:bg-gray-800 transition-colors flex items-center justify-center border border-gray-800" title="YouTube">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Produced Tabs Grids / Columns -->
            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Left Details Grid: Produced works (Movies, Songs, Web Series) -->
                <div class="lg:col-span-2 space-y-10">
                    
                    <!-- Movies Tab -->
                    <div>
                        <h3 class="text-xl font-black text-white mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-yellow-500 rounded"></span> Produced Movies
                            <span class="ml-2 text-xs font-bold text-gray-400 bg-gray-800/80 px-2 py-0.5 rounded-full border border-gray-700/50">
                                {{ $movies->count() }}
                            </span>
                        </h3>

                        @if($movies->isEmpty())
                            <p class="text-gray-400 italic bg-gray-900/30 rounded-2xl p-6 text-center border border-gray-850">No produced movies listed yet.</p>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                                @foreach($movies as $movie)
                                    <a href="{{ route('movie.show', $movie->slug) }}" class="group">
                                        <div class="bg-gray-900/60 rounded-2xl overflow-hidden shadow-lg border border-gray-800/50 hover:border-yellow-500/50 hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
                                            <div class="relative overflow-hidden aspect-[2/3] w-full bg-gray-950">
                                                @if($movie->poster_image)
                                                    <img src="{{ asset('storage/' . $movie->poster_image) }}" alt="{{ $movie->title }}"
                                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-600 bg-gray-900/50">
                                                        <i class="fa-regular fa-image text-3xl mb-2"></i>
                                                        <span class="text-xs">No Poster</span>
                                                    </div>
                                                @endif
                                                <div class="absolute top-2 right-2 bg-black/60 backdrop-blur-md text-yellow-500 text-[10px] font-black py-0.5 px-2 rounded-full border border-yellow-500/20">
                                                    <i class="fa fa-star text-[9px] mr-0.5"></i> {{ $movie->cg_chartbusters_ratings ?? 0 }}
                                                </div>
                                            </div>
                                            <div class="p-3.5 flex-1 flex flex-col justify-between">
                                                <div>
                                                    <h4 class="text-sm font-bold text-white group-hover:text-yellow-500 transition-colors line-clamp-1">
                                                        {{ preg_replace('/^\d+[\s.-]+/', '', $movie->title) }}
                                                    </h4>
                                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mt-1">
                                                        {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format($movie->is_release_year_only ? 'Y' : 'M Y') : 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Web Series Tab -->
                    <div>
                        <h3 class="text-xl font-black text-white mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-yellow-500 rounded"></span> Produced Web Series
                            <span class="ml-2 text-xs font-bold text-gray-400 bg-gray-800/80 px-2 py-0.5 rounded-full border border-gray-700/50">
                                {{ $tvShows->count() }}
                            </span>
                        </h3>

                        @if($tvShows->isEmpty())
                            <p class="text-gray-400 italic bg-gray-900/30 rounded-2xl p-6 text-center border border-gray-850">No produced web series listed yet.</p>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                                @foreach($tvShows as $show)
                                    <a href="{{ route('tv-show.show', $show->slug) }}" class="group">
                                        <div class="bg-gray-900/60 rounded-2xl overflow-hidden shadow-lg border border-gray-800/50 hover:border-yellow-500/50 hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
                                            <div class="relative overflow-hidden aspect-[2/3] w-full bg-gray-950">
                                                @if($show->poster_image)
                                                    <img src="{{ asset('storage/' . $show->poster_image) }}" alt="{{ $show->title }}"
                                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-600 bg-gray-900/50">
                                                        <i class="fa-regular fa-image text-3xl mb-2"></i>
                                                        <span class="text-xs">No Poster</span>
                                                    </div>
                                                @endif
                                                <div class="absolute top-2 right-2 bg-black/60 backdrop-blur-md text-yellow-500 text-[10px] font-black py-0.5 px-2 rounded-full border border-yellow-500/20">
                                                    <i class="fa fa-star text-[9px] mr-0.5"></i> {{ $show->cg_chartbusters_ratings ?? 0 }}
                                                </div>
                                            </div>
                                            <div class="p-3.5 flex-1 flex flex-col justify-between">
                                                <div>
                                                    <h4 class="text-sm font-bold text-white group-hover:text-yellow-500 transition-colors line-clamp-1">
                                                        {{ preg_replace('/^\d+[\s.-]+/', '', $show->title) }}
                                                    </h4>
                                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-wider mt-1">
                                                        {{ $show->release_date ? \Carbon\Carbon::parse($show->release_date)->format($show->is_release_year_only ? 'Y' : 'M Y') : 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Songs Tab -->
                    <div>
                        <h3 class="text-xl font-black text-white mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-yellow-500 rounded"></span> Produced Songs
                            <span class="ml-2 text-xs font-bold text-gray-400 bg-gray-800/80 px-2 py-0.5 rounded-full border border-gray-700/50">
                                {{ $songs->count() }}
                            </span>
                        </h3>

                        @if($songs->isEmpty())
                            <p class="text-gray-400 italic bg-gray-900/30 rounded-2xl p-6 text-center border border-gray-850">No produced songs listed yet.</p>
                        @else
                            <div class="space-y-3.5">
                                @foreach($songs as $song)
                                    <div class="flex items-center justify-between p-4 bg-gray-900/50 rounded-2xl border border-gray-850 hover:bg-gray-900/90 hover:border-yellow-500/25 transition-all duration-300">
                                        <div class="flex items-center gap-4 min-w-0">
                                            <img src="{{ $song->poster_image ? asset('storage/' . $song->poster_image) : asset('images/placeholder.png') }}" alt="{{ $song->title }}" class="w-12 h-12 rounded-xl object-cover border border-gray-800">
                                            <div class="min-w-0">
                                                <h4 class="text-sm font-bold text-white truncate"><a href="{{ route('song.show', $song->slug) }}" class="hover:text-yellow-400 transition-colors">{{ $song->title }}</a></h4>
                                                <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-widest">
                                                    {{ $song->release_date ? \Carbon\Carbon::parse($song->release_date)->format('Y') : 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="text-right">
                                                <div class="text-yellow-500 text-xs font-black flex items-center justify-end gap-1">
                                                    <i class="fa fa-star text-[10px]"></i>
                                                    <span>{{ $song->cg_chartbusters_ratings ?? 0 }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('song.show', $song->slug) }}" class="w-8 h-8 rounded-lg bg-gray-800 text-gray-300 flex items-center justify-center hover:bg-yellow-500 hover:text-black transition-all">
                                                <i class="fas fa-play text-xs pl-0.5"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Right Sidebar: Reviews & Rating Form -->
                <div class="lg:col-span-1 space-y-8">
                    
                    <!-- Rating and Review Form block -->
                    <div id="review-section" class="bg-gray-900/60 border border-gray-800/80 rounded-2xl p-6 shadow-xl">
                        <h3 class="mb-4 text-lg font-bold text-white">Post Profile Review</h3>
                        <form action="{{ route('artists.reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="artist_id" value="{{ $productionHouse->id }}">

                            <div class="mb-4">
                                <x-input-label for="review_text" :value="__('Review Comments')" class="text-gray-400 text-xs font-bold uppercase tracking-wider" />
                                <x-textarea id="review_text"
                                    class="block mt-2 w-full bg-gray-950 border-gray-800 text-white rounded-xl focus:ring-yellow-500 focus:border-yellow-500 placeholder-gray-600 text-sm"
                                    name="review_text" rows="4" placeholder="Write your thoughts..."
                                    required>{{ old('review_text') }}</x-textarea>
                                <x-input-error :messages="$errors->get('review_text')" class="mt-2" />
                            </div>

                            <div class="mb-5">
                                <x-input-label for="rating" :value="__('Rate (1 to 10 Stars)')" class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-2 block" />
                                <x-star-rating id="rating" class="block" name="rating" required></x-star-rating>
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <x-input-submit
                                class="w-full rounded-xl bg-yellow-500 px-6 py-3 font-black text-black hover:bg-yellow-600 active:scale-95 transition-all text-xs uppercase tracking-widest shadow-xl shadow-yellow-500/10">
                                Submit Profile Review
                            </x-input-submit>
                        </form>
                    </div>

                    <!-- Reviews List block -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-black text-white flex items-center gap-2">
                            <span class="w-1 h-5 bg-yellow-500 rounded"></span> Review Feed
                        </h3>

                        <div class="space-y-4 max-h-[30rem] overflow-y-auto pr-2">
                            @forelse($reviews as $review)
                                <div class="review-item rounded-2xl border border-gray-850 bg-gray-900/40 p-4 shadow-md">
                                    <div class="flex flex-wrap items-start justify-between gap-2 mb-3">
                                        <div class="flex items-center min-w-0">
                                            <i class="fa-solid fa-user-circle text-yellow-400 text-2xl mr-3 shrink-0"></i>
                                            <div class="min-w-0">
                                                <strong class="break-words text-yellow-300 text-xs font-bold">
                                                    {!! $review->user ? $review->user->name : '<span class="text-gray-600">[deleted]</span>' !!}
                                                </strong>
                                                <div class="mt-1 flex items-center gap-x-1">
                                                    @for($i = 1; $i <= 10; $i++)
                                                        <i class="fa fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-800' }} text-[9px]"></i>
                                                    @endfor
                                                    <span class="ml-1 text-[9px] text-gray-400 font-bold">{{ $review->rating }}/10</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-[9px] text-gray-500 font-bold uppercase tracking-wider">{{ $review->created_at->format('d M y') }}</span>
                                    </div>
                                    <p class="break-words text-gray-300 text-xs leading-relaxed">{{ $review->review_text }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500 italic bg-gray-900/20 rounded-2xl p-4 text-center text-xs border border-gray-850">Be the first to review this production house profile.</p>
                            @endforelse
                        </div>

                        @if($reviews->hasPages())
                            <div class="paginate mt-4">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Recommended Production Houses -->
                    @if($recommended->isNotEmpty())
                        <div class="space-y-4 pt-4 border-t border-gray-850">
                            <h3 class="text-lg font-black text-white flex items-center gap-2">
                                <span class="w-1 h-5 bg-yellow-500 rounded"></span> Other Production Houses
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($recommended as $ph)
                                    <a href="{{ route('production-house.show', $ph->slug) }}" class="group">
                                        <div class="p-3 bg-gray-900/60 rounded-2xl border border-gray-850 hover:border-yellow-500/40 hover:bg-gray-900 transition-all text-center h-full flex flex-col items-center justify-center">
                                            <img src="{{ $ph->photo ? asset('storage/' . $ph->photo) : asset('images/placeholder.png') }}" alt="{{ $ph->name }}" class="w-14 h-14 rounded-xl object-cover border border-gray-800 mb-2">
                                            <h4 class="text-xs font-bold text-white group-hover:text-yellow-400 transition-colors line-clamp-1">{{ $ph->name }}</h4>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
