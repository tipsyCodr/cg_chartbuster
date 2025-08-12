<x-app-layout>
    @php
    $artist = new App\Models\Artist();
    @endphp
    
    <style>
        .hero-section {
            min-height: 400px;
        }
        
        .hero-media iframe {
            width: 100%;
            height: 100%;
            min-height: 300px;
            aspect-ratio: 16 / 9;
            border-radius: 0.75rem;
        }
        
        .hero-media img {
            width: 100%;
            height: 100%;
            min-height: 300px;
            object-cover: cover;
            border-radius: 0.75rem;
        }
        
        .poster-thumb {
            width: 110px;
            height: 140px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        
        .cast-member {
            transition: all 0.3s ease;
        }
        
        .cast-member:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        .review-item {
            transition: all 0.2s ease;
        }
        
        .review-item:hover {
            background-color: rgba(31, 41, 55, 0.7);
        }
        
        .paginate p {
            color: white;
            padding: 0 15px;
        }
    </style>

    <div class="container mx-auto px-4 py-6">
        <!-- Hero Section -->
        <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-8">
            <div class="flex flex-col lg:flex-row">
                <!-- Media Section -->
                <div class="lg:w-2/3 hero-section">
                    <div class="hero-media h-full p-4">
                        @if($song->trailer_url != "" && $song->trailer_url != " " && str_contains($song->trailer_url,'http'))
                            {!! $song->trailer_url !!}
                        @elseif($song->poster_image_landscape != "" && $song->poster_image_landscape != " ")
                            <img src="{{ asset("storage/{$song->poster_image_landscape}") }}" alt="{{ $song->title }}" class="rounded-lg">
                        @elseif($song->poster_image != "" && $song->poster_image != " ")
                            <img src="{{ asset('storage/'.$song->poster_image) }}" alt="{{ $song->title }}" class="rounded-lg">
                        @endif
                    </div>
                </div>
                
                <!-- Info Section -->
                <div class="lg:w-1/3 p-6">
                    <div class="flex gap-4 mb-4">
                        <!-- Poster Thumbnail -->
                        @if($song->poster_image != "" && $song->poster_image != " ")
                            <div class="flex-shrink-0">
                                <img src="{{ asset("storage/{$song->poster_image}") }}" alt="{{ $song->title }}" class="poster-thumb">
                            </div>
                        @endif
                        
                        <!-- Basic Info -->
                        <div class="flex-1">
                            <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">{{ $song->title }}</h1>
                            <div class="space-y-1 text-sm text-gray-300">
                                <div class="flex items-center gap-1">
                                    <i class="fa fa-star text-yellow-400 text-xs"></i>
                                    <span>{{ $song->rating }} / 5</span>
                                </div>
                                <div>Released: {{ date('Y', strtotime($song->release_date)) }}</div>
                                <div><strong>{{ $song->genre }}</strong></div>
                                <div><strong>{{ substr($song->duration, 0, 5) }}</strong> mins</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-white mb-2">Plot</h3>
                        <div class="max-h-32 overflow-y-auto text-gray-300 text-sm leading-relaxed">
                            {{ $song->description }}
                        </div>
                    </div>
                    
                    <!-- Singers -->
                    <div class="space-y-2 text-sm">
                        @if($song->singer_male && $singer_male = $artist->find($song->singer_male))
                            <div>
                                <span class="text-gray-400">Male Singer:</span>
                                <a href="{{ route('artist.show', $singer_male->id) }}" class="text-yellow-400 hover:text-yellow-300 ml-1">
                                    {{ $singer_male->name }}
                                </a>
                            </div>
                        @endif
                        @if($song->singer_female && $singer_female = $artist->find($song->singer_female))
                            <div>
                                <span class="text-gray-400">Female Singer:</span>
                                <a href="{{ route('artist.show', $singer_female->id) }}" class="text-yellow-400 hover:text-yellow-300 ml-1">
                                    {{ $singer_female->name }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Cast Section -->
            <div class='py-5'>
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <span class="w-1 h-6 bg-yellow-500 mr-3"></span>
                    Cast
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($song->artists as $artist)
                        <a href="{{ route('artist.show', $artist->id) }}" class="cast-member flex items-center bg-gray-800 rounded-lg p-4 hover:bg-gray-700">
                            <img src="{{ asset('storage/' . $artist->photo) }}" alt="{{ $artist->name }}" class="w-16 h-16 rounded-full object-cover mr-4 border-2 border-gray-600">
                            <div>
                                <h4 class="text-lg font-semibold text-white">{{ $artist->name }}</h4>
                                @php
                                    $roleId = $artist->pivot->artist_category_id;
                                    $roleName = \App\Models\ArtistCategory::find($roleId)?->name ?? 'Unknown';
                                @endphp
                                <p class="text-sm text-gray-400">{{ $roleName }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Reviews Section -->
            <div class='py-5'>
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <span class="w-1 h-6 bg-yellow-500 mr-3"></span>
                    Reviews
                </h2>
                
                <!-- Review Form -->
                <div class="bg-gray-800 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-white mb-4">Post a Review</h3>
                    
                    <form action="{{ route('songs.reviews.store', $song) }}" method="POST">
                        @csrf
                        @if (session('error'))
                            <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-200 px-4 py-3 rounded mb-4">
                                <strong>{{ session('error') }}</strong>
                            </div>
                        @endif
                        
                        <input type="hidden" name="song_id" value="{{ $song->id }}">
                        
                        <div class="mb-4">
                            <x-input-label for="review_text" :value="__('Review')" class="text-gray-300" />
                            <x-textarea id="review_text" class="block mt-2 w-full bg-gray-700 border-gray-600 text-white rounded-md" name="review_text" rows="4" placeholder="Write your review..." required>{{ old('review_text') }}</x-textarea>
                            <x-input-error :messages="$errors->get('review_text')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="rating" :value="__('Rating')" class="text-gray-300" />
                            <x-star-rating id="rating" class="block mt-2" name="rating" required></x-star-rating>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>
                        
                        <x-input-submit class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-2 px-6 rounded-md transition-colors">
                            Submit Review
                        </x-input-submit>
                    </form>
                </div>
                
                <!-- Reviews List -->
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="review-item border border-gray-700 rounded-lg p-4 bg-gray-800">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-user-circle text-yellow-400 text-2xl mr-3"></i>
                                    <div>
                                        <strong class="text-yellow-300">
                                            {!! $review->user ? $review->user->name : '<span class="text-gray-500">[deleted account]</span>' !!}
                                        </strong>
                                        <div class="flex items-center mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }} text-sm"></i>
                                            @endfor
                                            <span class="text-gray-400 text-sm ml-2">{{ $review->rating }}/5</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <p class="text-gray-300 leading-relaxed">{{ $review->review_text }}</p>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-6 paginate">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>