<x-app-layout>
    @php
    $artistModel = new App\Models\Artist();
    @endphp

    <div class="container mx-auto px-4 py-6">

        <!-- Hero Section -->
        <div class="bg-gray-800 rounded-xl shadow-2xl overflow-hidden mb-8 grid lg:grid-cols-3 gap-6">

            <!-- Left: Media -->
            <div class="lg:col-span-2 hero-section p-4">
                <div class="hero-media h-full w-full">
                    @if($song->trailer_url && str_contains($song->trailer_url,'http'))
                        {!! $song->trailer_url !!}
                    @elseif($song->poster_image_landscape)
                        <img src="{{ asset("storage/{$song->poster_image_landscape}") }}" alt="{{ $song->title }}" class="w-full h-full object-cover rounded-lg">
                    @elseif($song->poster_image)
                        <img src="{{ asset("storage/{$song->poster_image}") }}" alt="{{ $song->title }}" class="w-full h-full object-cover rounded-lg">
                    @endif
                </div>
            </div>

            <!-- Right: Song Info -->
            <div class="lg:col-span-1 p-6 flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-4">{{ $song->title }}</h1>
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fa fa-star text-yellow-400"></i>
                        <span class="text-gray-300">{{ $song->rating }} / 5</span>
                    </div>
                    <div class="text-gray-300 mb-2"><strong>Released:</strong> {{ date('Y', strtotime($song->release_date)) }}</div>
                    <div class="text-gray-300 mb-2"><strong>Genre:</strong> {{ $song->genre }}</div>
                    <div class="text-gray-300 mb-4"><strong>Duration:</strong> {{ substr($song->duration,0,5) }} mins</div>

                    <!-- Plot -->
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-2">Plot</h3>
                        <div class="max-h-40 overflow-y-auto text-gray-300 text-sm leading-relaxed">
                            {{ $song->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Cast & Reviews -->
        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Cast -->
            <div class="lg:col-span-2 py-5">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <span class="w-1 h-6 bg-yellow-500 mr-3"></span>Cast & Roles
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

            <!-- Reviews -->
            <div class="py-5">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <span class="w-1 h-6 bg-yellow-500 mr-3"></span>Reviews
                </h2>

                <!-- Review Form -->
                <div class="bg-gray-800 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-white mb-4">Post a Review</h3>
                    <form action="{{ route('songs.reviews.store', $song) }}" method="POST">
                        @csrf
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

                <div class="mt-6 paginate">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
