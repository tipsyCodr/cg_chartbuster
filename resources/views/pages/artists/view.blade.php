<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Artist Details') }}
        </h2>
    </x-slot>

    @section('meta_title', $artists->name . ' - CG Chartbusters')
    @section('meta_description', \Illuminate\Support\Str::limit(strip_tags($artists->bio ?? 'Explore ' . $artists->name . '\'s profile, movies, and songs on CG Chartbusters.'), 160))
    @section('meta_image', $artists->photo ? asset('storage/' . $artists->photo) : asset('images/placeholder.png'))
    @section('og_type', 'profile')

    <div class="px-3 py-6 sm:px-5 max-w-7xl mx-auto">
        <!-- Artist Profile Section -->
        <div class="bg-gray-800/40 backdrop-blur-md rounded-2xl border border-gray-700/50 p-6 shadow-xl mb-10">
            <div class="flex flex-col md:flex-row gap-6 items-start">
                <img class="h-40 w-40 sm:h-48 sm:w-48 rounded-xl object-cover shadow-2xl border border-gray-700 shrink-0"
                    src="{{ $artists->photo ? asset('storage/' . $artists->photo) : asset('images/placeholder.png') }}"
                    alt="{{ $artists->name }}">
                <div class="flex-1 min-w-0">
                    <h1 class="break-words text-2xl font-black text-white sm:text-3xl lg:text-4xl">{{ $artists->name }}</h1>
                    <div class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-gray-900/60 px-3 py-1 text-xs text-yellow-500 font-bold border border-gray-700/50">
                        <img src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating" class="w-4 h-4">
                        <span>{{ $artists->cgcb_rating ?? '0' }} / 10 ({{ $reviews->total() }} Ratings)</span>
                    </div>
                    @php
                        $categoryIds = $artists->category ?? [];
                        $selectedCategories = collect();

                        if (!empty($categoryIds)) {
                            if (!is_array($categoryIds)) {
                                $categoryIds = [$categoryIds];
                            }
                            $selectedCategories = \App\Models\ArtistCategory::whereIn('id', $categoryIds)->get();
                        }
                    @endphp
                    @if($selectedCategories->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach ($selectedCategories as $cat)
                                <span class="rounded bg-gray-700/80 px-2.5 py-1 text-xs font-semibold text-gray-200 cursor-pointer hover:bg-gray-900 transition-colors border border-gray-600/30">
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic mt-3 text-sm">No categories assigned</p>
                    @endif

                    <!-- Birth Date -->
                    <div class="mt-4 pt-4 border-t border-gray-700/30">
                        <h3 class="text-xs uppercase tracking-wider font-bold text-gray-400">Date of Birth</h3>
                        <p class="text-gray-200 text-sm mt-0.5">
                            {{ $artists->birth_date ? \Carbon\Carbon::parse($artists->birth_date)->format($artists->is_release_year_only ? 'Y' : 'F j, Y') : 'N/A' }}
                        </p>
                    </div>

                    <!-- Biography -->
                    <div class="mt-6 pt-4 border-t border-gray-700/30">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 gap-3">
                            <h3 class="text-xs uppercase tracking-wider font-bold text-gray-400">Biography</h3>
                            <x-language-switcher variant="compact" />
                        </div>
                        <div class="text-gray-300 leading-relaxed text-sm sm:text-base max-w-4xl">
                            @if(app()->getLocale() == 'chh' && !empty($artists->bio_chh))
                                {!! nl2br(e($artists->bio_chh)) !!}
                            @elseif(app()->getLocale() == 'hi' && !empty($artists->bio_hi))
                                {!! nl2br(e($artists->bio_hi)) !!}
                            @else
                                {!! nl2br(e($artists->bio)) !!}
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <button onclick="document.getElementById('review-section').scrollIntoView({behavior:'smooth'})" 
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-yellow-500 text-black font-black rounded-lg hover:bg-yellow-600 transition-all shadow-xl active:scale-95 group">
                            <i class="fa-solid fa-star transition-transform group-hover:rotate-12"></i>
                            Rate This Artist
                        </button>
                        <x-social-share :url="url()->current()" :title="$artists->name" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Artist Movies & Reviews Section -->
        <div class="grid gap-6 lg:grid-cols-3 lg:gap-8 mt-12">
            <!-- Left: Media Sliders -->
            <div class="lg:col-span-2">
                <!-- Movies -->
                <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-7 bg-yellow-500 rounded"></span> Movies
                </h3>

                @if($artists->movies->isEmpty())
                    <p class="text-gray-400 italic bg-gray-800/20 rounded-xl p-6 text-center border border-gray-700/30">No movies found</p>
                @else
                    <div class="relative group/slider mb-12">
                        <div class="swiper artist-movie-slider !pr-4 overflow-visible">
                            <div class="swiper-wrapper">
                                @foreach($artists->movies as $movie)
                                    <div class="swiper-slide">
                                        <a href="{{ route('movie.show', $movie->slug) }}" class="group block h-full">
                                            <div class="bg-gray-800/40 rounded-xl overflow-hidden shadow-lg border border-gray-700/50 hover:border-yellow-500/50 hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
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
                                                </div>
                                                <div class="p-3 flex-1 flex flex-col justify-between">
                                                    <div>
                                                        <h4 class="text-sm font-bold text-white group-hover:text-yellow-500 transition-colors line-clamp-1">
                                                            {{ preg_replace('/^\d+[\s.-]+/', '', $movie->title) }}
                                                        </h4>
                                                        <p class="text-gray-400 text-[10px] mt-1">
                                                            {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format($movie->is_release_year_only ? 'Y' : 'd M Y') : 'N/A' }}
                                                        </p>
                                                    </div>
                                                    {{-- Show Artist Category --}}
                                                    @php
                                                        $categoryNames = $movie->pivot->category_names;
                                                    @endphp
                                                    @if(!empty($categoryNames))
                                                        <div class="mt-2 pt-2 border-t border-gray-700/30">
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach($categoryNames as $name)
                                                                    <span class="px-1.5 py-0.5 bg-gray-900/60 text-gray-300 rounded text-[8px] font-semibold tracking-wide uppercase">
                                                                        {{ $name }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Navigation -->
                        <div class="artist-movie-next absolute top-1/2 -right-4 z-50 flex items-center justify-center w-8 h-8 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </div>
                        <div class="artist-movie-prev absolute top-1/2 -left-4 z-50 flex items-center justify-center w-8 h-8 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </div>
                    </div>
                @endif

                <!-- Songs -->
                <h3 class="text-2xl font-black text-white mt-12 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-7 bg-yellow-500 rounded"></span> Songs
                </h3>

                @if($artists->songs->isEmpty())
                    <p class="text-gray-400 italic bg-gray-800/20 rounded-xl p-6 text-center border border-gray-700/30">No songs found</p>
                @else
                    <div class="relative group/slider mb-12">
                        <div class="swiper artist-song-slider !pr-4 overflow-visible">
                            <div class="swiper-wrapper">
                                @foreach($artists->songs as $song)
                                    <div class="swiper-slide">
                                        <a href="{{ route('song.show', $song->slug) }}" class="group block h-full">
                                            <div class="bg-gray-800/40 rounded-xl overflow-hidden shadow-lg border border-gray-700/50 hover:border-yellow-500/50 hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
                                                <div class="relative overflow-hidden aspect-[2/3] w-full bg-gray-950">
                                                    @if($song->poster_image)
                                                        <img src="{{ asset('storage/' . $song->poster_image) }}" alt="{{ $song->title }}"
                                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                    @else
                                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-600 bg-gray-900/50">
                                                            <i class="fa-regular fa-image text-3xl mb-2"></i>
                                                            <span class="text-xs">No Poster</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="p-3 flex-1 flex flex-col justify-between">
                                                    <div>
                                                        <h4 class="text-sm font-bold text-white group-hover:text-yellow-500 transition-colors line-clamp-1">
                                                            {{ preg_replace('/^\d+[\s.-]+/', '', $song->title) }}
                                                        </h4>
                                                        <p class="text-gray-400 text-[10px] mt-1">
                                                            {{ $song->release_date ? \Carbon\Carbon::parse($song->release_date)->format($song->is_release_year_only ? 'Y' : 'd M Y') : 'N/A' }}
                                                        </p>
                                                    </div>
                                                    {{-- Show Artist Category --}}
                                                    @php
                                                        $categoryNames = $song->pivot->category_names;
                                                    @endphp
                                                    @if(!empty($categoryNames))
                                                        <div class="mt-2 pt-2 border-t border-gray-700/30">
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach($categoryNames as $name)
                                                                    <span class="px-1.5 py-0.5 bg-gray-900/60 text-gray-300 rounded text-[8px] font-semibold tracking-wide uppercase">
                                                                        {{ $name }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Navigation -->
                        <div class="artist-song-next absolute top-1/2 -right-4 z-50 flex items-center justify-center w-8 h-8 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </div>
                        <div class="artist-song-prev absolute top-1/2 -left-4 z-50 flex items-center justify-center w-8 h-8 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </div>
                    </div>
                @endif

                <!-- TV Shows -->
                <h3 class="text-2xl font-black text-white mt-12 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-7 bg-yellow-500 rounded"></span> TV Shows
                </h3>

                @if($artists->tvshows->isEmpty())
                    <p class="text-gray-400 italic bg-gray-800/20 rounded-xl p-6 text-center border border-gray-700/30">No TV shows found</p>
                @else
                    <div class="relative group/slider mb-12">
                        <div class="swiper artist-tvshow-slider !pr-4 overflow-visible">
                            <div class="swiper-wrapper">
                                @foreach($artists->tvshows as $tvshow)
                                    <div class="swiper-slide">
                                        <a href="{{ route('tv-show.show', $tvshow->slug) }}" class="group block h-full">
                                            <div class="bg-gray-800/40 rounded-xl overflow-hidden shadow-lg border border-gray-700/50 hover:border-yellow-500/50 hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
                                                <div class="relative overflow-hidden aspect-[2/3] w-full bg-gray-950">
                                                    @if($tvshow->poster_image)
                                                        <img src="{{ asset('storage/' . $tvshow->poster_image) }}" alt="{{ $tvshow->title }}"
                                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                    @else
                                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-600 bg-gray-900/50">
                                                            <i class="fa-regular fa-image text-3xl mb-2"></i>
                                                            <span class="text-xs">No Poster</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="p-3 flex-1 flex flex-col justify-between">
                                                    <div>
                                                        <h4 class="text-sm font-bold text-white group-hover:text-yellow-500 transition-colors line-clamp-1">
                                                            {{ preg_replace('/^\d+[\s.-]+/', '', $tvshow->title) }}
                                                        </h4>
                                                        <p class="text-gray-400 text-[10px] mt-1">
                                                            {{ $tvshow->release_date ? \Carbon\Carbon::parse($tvshow->release_date)->format($tvshow->is_release_year_only ? 'Y' : 'd M Y') : 'N/A' }}
                                                        </p>
                                                    </div>
                                                    {{-- Show Artist Category --}}
                                                    @php
                                                        $categoryNames = $tvshow->pivot->category_names;
                                                    @endphp
                                                    @if(!empty($categoryNames))
                                                        <div class="mt-2 pt-2 border-t border-gray-700/30">
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach($categoryNames as $name)
                                                                    <span class="px-1.5 py-0.5 bg-gray-900/60 text-gray-300 rounded text-[8px] font-semibold tracking-wide uppercase">
                                                                        {{ $name }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Navigation -->
                        <div class="artist-tvshow-next absolute top-1/2 -right-4 z-50 flex items-center justify-center w-8 h-8 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </div>
                        <div class="artist-tvshow-prev absolute top-1/2 -left-4 z-50 flex items-center justify-center w-8 h-8 bg-gray-900/90 backdrop-blur-md border border-white/10 text-white hover:bg-yellow-500 hover:text-black rounded-full cursor-pointer shadow-2xl transition-all -translate-y-1/2 hover:scale-110 opacity-70 hover:opacity-100">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Reviews & Popular Artists -->
            <div class="lg:col-span-1">
                <div class="lg:sticky lg:top-6 lg:self-start space-y-6">
                    <h2 class="mb-6 flex items-center text-lg font-black text-white sm:text-xl md:text-2xl">
                        <span class="w-1.5 h-6 bg-yellow-500 mr-3 rounded"></span>Reviews
                    </h2>

                    <!-- Review Form -->
                    <div id="review-section" class="bg-gray-800/60 border border-gray-700/50 rounded-xl p-4 sm:p-6 shadow-xl">
                        <h3 class="mb-4 text-lg font-bold text-white sm:text-xl">Post a Review</h3>
                        <form action="{{ route('artists.reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="artist_id" value="{{ $artists->id }}">

                            <div class="mb-4">
                                <x-input-label for="review_text" :value="__('Review')" class="text-gray-300 text-sm font-semibold" />
                                <x-textarea id="review_text"
                                    class="block mt-2 w-full bg-gray-700 border-gray-600 text-white rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                                    name="review_text" rows="4" placeholder="Write your review..."
                                    required>{{ old('review_text') }}</x-textarea>
                                <x-input-error :messages="$errors->get('review_text')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="rating" :value="__('Rating')" class="text-gray-300 text-sm font-semibold" />
                                <x-star-rating id="rating" class="block mt-2 w-full" name="rating" required></x-star-rating>
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <x-input-submit
                                class="w-full rounded-lg bg-yellow-500 px-6 py-2.5 font-bold text-black transition-colors hover:bg-yellow-600">
                                Submit Review
                            </x-input-submit>
                        </form>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-4 text-gray-200">
                        @forelse($reviews as $review)
                            <div class="review-item rounded-xl border border-gray-700/50 bg-gray-800/40 p-4 shadow-md">
                                <div class="flex flex-wrap items-start justify-between gap-2 mb-3">
                                    <div class="flex items-center min-w-0">
                                        <i class="fa-solid fa-user-circle text-yellow-400 text-2xl mr-3 shrink-0"></i>
                                        <div class="min-w-0">
                                            <strong class="break-words text-yellow-300 text-sm">
                                                {!! $review->user ? $review->user->name : '<span class="text-gray-500">[deleted account]</span>' !!}
                                            </strong>
                                            <div class="mt-1 flex flex-wrap items-center gap-x-1 gap-y-1">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <i class="fa fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }} text-[10px]"></i>
                                                @endfor
                                                <span class="ml-1 text-[10px] text-gray-400 font-bold">{{ $review->rating }}/10</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-gray-500 sm:ml-auto">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="leading-relaxed text-gray-300 text-sm break-words">{{ $review->review_text }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic bg-gray-850/50 rounded-xl p-4 text-center text-sm border border-gray-800/30">No reviews yet. Be the first to review!</p>
                        @endforelse
                    </div>

                    @if($reviews->hasPages())
                        <div class="paginate mt-6 overflow-x-auto">
                            {{ $reviews->links() }}
                        </div>
                    @endif

                    <!-- Popular Artists Widget to Fill Empty Space -->
                    @php
                        $popularArtists = \App\Models\Artist::where('id', '!=', $artists->id)
                            ->orderByDesc('cgcb_rating')
                            ->take(5)
                            ->get();
                    @endphp
                    @if($popularArtists->isNotEmpty())
                        <div class="bg-gray-800/40 rounded-xl p-4 sm:p-5 border border-gray-700/50 shadow-xl">
                            <h3 class="mb-4 text-xs font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                <span class="w-1 h-4 bg-yellow-500 rounded"></span> Popular Artists
                            </h3>
                            <div class="space-y-4">
                                @foreach($popularArtists as $popArtist)
                                    <a href="{{ route('artist.show', $popArtist->slug) }}" class="flex items-center gap-3 group">
                                        <div class="w-10 h-10 rounded-full overflow-hidden shrink-0 border border-gray-700">
                                            <img src="{{ $popArtist->photo ? asset('storage/' . $popArtist->photo) : asset('images/placeholder.png') }}" 
                                                 alt="{{ $popArtist->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-sm font-bold text-gray-200 group-hover:text-yellow-500 transition-colors truncate">
                                                {{ $popArtist->name }}
                                            </h4>
                                            <div class="flex items-center gap-1 text-[10px] text-gray-400 mt-0.5">
                                                <i class="fa-solid fa-star text-yellow-500"></i>
                                                <span>{{ $popArtist->cgcb_rating ?? '0' }}/10</span>
                                            </div>
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
