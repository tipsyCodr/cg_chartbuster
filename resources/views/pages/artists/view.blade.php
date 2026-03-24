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

    <div class="px-3 py-6 sm:px-5">
        <!-- Artist Profile Section -->
        <div class="flex flex-col items-start gap-6 lg:flex-row">
            <div class="flex flex-col gap-4 md:flex-row">
                <img class="h-40 w-40 rounded-md object-cover shadow-md sm:h-52 sm:w-52"
                    src="{{ $artists->photo ? asset('storage/' . $artists->photo) : asset('images/placeholder.png') }}"
                    alt="{{ $artists->name }}">
                <div class="">
                    <h1 class="break-words text-2xl font-bold text-gray-100 sm:text-3xl">{{ $artists->name }}</h1>
                    <div class="mb-4 inline-flex items-center gap-1 rounded-full bg-gray-700/60 px-3 py-1 text-xs text-gray-200">
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
                        <div class="flex gap-3 py-2 overflow-x-auto hide-scrollbar w-full max-w-full sm:max-w-[600px]">
                            @foreach ($selectedCategories as $cat)
                                <small
                                    class="w-fit shrink-0 whitespace-nowrap rounded bg-gray-700 px-2 py-1 text-white cursor-pointer hover:bg-gray-900">
                                    {{ $cat->name }}
                                </small>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">No categories assigned</p>
                    @endif

                    <!-- Birth Date -->
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-100">Date of Birth</h3>
                        <p class="text-gray-200">
                            {{ $artists->birth_date ? \Carbon\Carbon::parse($artists->birth_date)->format($artists->is_release_year_only ? 'Y' : 'F j, Y') : 'N/A' }}
                        </p>
                    </div>
                    <div class="mt-6">
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
            <!-- Left: Movies -->
            <div class="lg:col-span-2">
                <h3 class="text-2xl font-semibold text-gray-100 mb-4">Movies</h3>

                @if($artists->movies->isEmpty())
                    <p class="text-gray-400 italic">No movies found</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($artists->movies as $movie)
                            <a href="{{ route('movie.show', $movie->slug) }}">
                                <div class="bg-gray-800 rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                                    @if($movie->poster_image)
                                        <img src="{{ asset('storage/' . $movie->poster_image) }}" alt="{{ $movie->title }}"
                                            class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 flex items-center justify-center bg-gray-700 text-gray-400 text-sm">
                                            No Image
                                        </div>
                                    @endif
                                    <div class="p-3">
                                        <h4 class="text-lg font-semibold text-white truncate">
                                            {{ $movie->title }}
                                        </h4>
                                        <p class="text-gray-400 text-sm">
                                            {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format($movie->is_release_year_only ? 'Y' : 'd M Y') : 'N/A' }}
                                        </p>
                                        {{-- Show Artist Category --}}
                                        @php
                                            $categoryNames = $movie->pivot->category_names;
                                        @endphp
                                        @if(!empty($categoryNames))
                                            <div class="mt-1 text-indigo-300 text-xs">
                                                <p>Role:</p>
                                                <div class="mt-1 flex flex-wrap gap-1">
                                                    @foreach($categoryNames as $name)
                                                        <span class="px-2 py-0.5 bg-gray-700 text-white cursor-pointer hover:bg-gray-900 rounded text-[10px]">
                                                            {{ $name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right: Reviews -->
            <div class="lg:col-span-1">
                <div class="lg:sticky lg:top-6 lg:self-start">
                    <h2 class="mb-6 flex items-center text-lg font-semibold text-white sm:text-xl md:text-2xl">
                        <span class="w-1 h-6 bg-yellow-500 mr-3"></span>Reviews
                    </h2>

                    <!-- Review Form -->
                    <div id="review-section" class="bg-gray-800 rounded-lg p-4 mb-6 sm:p-6">
                        <h3 class="mb-4 text-lg font-bold text-white sm:text-xl">Post a Review</h3>
                        <form action="{{ route('artists.reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="artist_id" value="{{ $artists->id }}">

                            <div class="mb-4">
                                <x-input-label for="review_text" :value="__('Review')" class="text-gray-300" />
                                <x-textarea id="review_text"
                                    class="block mt-2 w-full bg-gray-700 border-gray-600 text-white rounded-md"
                                    name="review_text" rows="4" placeholder="Write your review..."
                                    required>{{ old('review_text') }}</x-textarea>
                                <x-input-error :messages="$errors->get('review_text')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="rating" :value="__('Rating')" class="text-gray-300" />
                                <x-star-rating id="rating" class="block mt-2 w-full" name="rating" required></x-star-rating>
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <x-input-submit
                                class="w-full rounded-md bg-yellow-500 px-6 py-2 font-semibold text-black transition-colors hover:bg-yellow-600 sm:w-auto">
                                Submit Review
                            </x-input-submit>
                        </form>
                    </div>

                    <!-- Reviews List -->
                    <div class="space-y-3 text-gray-200 sm:space-y-4">
                        @foreach($reviews as $review)
                            <div class="review-item rounded-lg border border-gray-700 bg-gray-800 p-3 sm:p-4">
                                <div class="flex flex-wrap items-start justify-between gap-2 mb-3">
                                    <div class="flex items-center min-w-0">
                                        <i class="fa-solid fa-user-circle text-yellow-400 text-2xl mr-3 shrink-0"></i>
                                        <div class="min-w-0">
                                            <strong class="break-words text-yellow-300">
                                                {!! $review->user ? $review->user->name : '<span class="text-gray-500">[deleted account]</span>' !!}
                                            </strong>
                                            <div class="mt-1 flex flex-wrap items-center gap-x-1 gap-y-1">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <i class="fa fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }} text-xs"></i>
                                                @endfor
                                                <span class="ml-1 text-xs text-gray-400 sm:text-sm">{{ $review->rating }}/10</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500 sm:ml-auto">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="leading-relaxed text-gray-300 break-words">{{ $review->review_text }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="paginate mt-6 overflow-x-auto">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>


        <!-- Artist Songs Section -->
        {{-- <div class="mt-8">
            <h3 class="text-2xl font-semibold text-gray-800">Songs</h3>
            <ul class="mt-4 space-y-2">
                @foreach($artists->songs as $song)
                <li class="text-gray-700">{{ $song->title }} ({{ \Carbon\Carbon::parse($song->release_date)->format('Y')
                    }})</li>
                @endforeach
            </ul>
        </div> --}}

    </div>
</x-app-layout>
