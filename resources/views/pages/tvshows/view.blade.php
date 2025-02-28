<x-app-layout>
    @php
    $artist = new App\Models\Artist();
    @endphp
    <style>
        .hero {
            flex: 1; /* Make iframe take half the screen */
        }

        iframe {
            width: 100%; /* Make iframe responsive */
            height: 100%; /* Ensure iframe fills its container */
            aspect-ratio: 16 / 9; /* Maintain proper aspect ratio */
        }

        .hero, .content {
            min-width: 100%; /* Default to full width on small screens */
        }

        @media (min-width: 768px) {
            .hero, .content {
                min-width: 50%; /* Half width on medium+ screens */
            }
        }
    </style>
    <div class="px-5">
        <div class="flex flex-col overflow-hidden bg-gray-600 shadow-2xl rounded-xl shadow-gray-600 md:flex-row">
            <div class="flex-grow-1 hero">
                @if($tvshow->trailer_url != "" && $tvshow->trailer_url != " " )
                    {!! $tvshow->trailer_url !!}
                @elseif($tvshow->poster_image_landscape != "" && $tvshow->poster_image_landscape != " ")
                    <img class="w-full h-auto" src="{{ asset("storage/{$tvshow->poster_image_landscape}") }}" alt="">
                @endif
            </div>
            <div class="p-4 w-28 flex-shrink-1 content">
                <div class="h-30 py-1 overflow-hidden text-ellipsis whitespace-nowrap">
                    <div class="flex gap-2">
                        <div class="poster_image rounded-md overflow-hidden">
                            @if($tvshow->poster_image != "" && $tvshow->poster_image != " ")
                                <img class="w-full max-w-[110px] object-cover h-full" src="{{ asset("storage/{$tvshow->poster_image}") }}" alt="">
                            @endif
                        </div>
                        <div class="">
                            <h1 class="text-2xl font-bold">{{ $tvshow->title }}</h1>
                            <small class="text-gray-200">
                                <i class="text-xs text-yellow-300 fa fa-star" aria-hidden="true"></i>
                                {{ $tvshow->rating }} 4.3
                            </small> <br>
                            <small class="text-gray-200">Released: {{ date('Y', strtotime($tvshow->release_date)) }}</small><br> 
                            <small class="text-gray-200"><strong>{{ $tvshow->genre }}</strong></small> <br>
                            <small class="text-gray-200"><strong>{{ substr($tvshow->duration, 0, 5) }} </strong>mins</small> <br>
                        </div>

                    </div>
                </div>
                <div class="h-40 overflow-y-auto">
                    <p><strong>Plot:</strong></p>
                    <p class="text-gray-200">{{ $tvshow->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-5 overflow-hidden  shadow-xl sm:rounded-lg">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full px-4 md:w-1/2">
                        <h2 class="mb-5 text-2xl font-semibold leading-tight text-gray-100">{{ $tvshow->title }}</h2>
                        <p class="mb-5 text-gray-200">{{ $tvshow->description }}</p>
                        <p class="mb-5 text-gray-200">Rating: {{ $tvshow->rating }}</p>
                        <p class="mb-5 text-gray-200">Release Date: {{ $tvshow->release_date }}</p>
                        <p class="mb-5 text-gray-200">Genre: {{ $tvshow->genre }}</p>
                        <p class="mb-5 text-gray-200">Duration: {{ $tvshow->duration }} minutes</p>
                        <p class="mb-5 text-gray-200">Director: {{ $tvshow->director }}</p>
                        <p class="mb-5 text-gray-200">Writer: {{ $tvshow->writer }}</p>
                        <p class="mb-5 text-gray-200">Producer: {{ $tvshow->producer }}</p>
                        <p class="mb-5 text-gray-200">Production Company: {{ $tvshow->production_company }}</p>
                        <p class="mb-5 text-gray-200">Country: {{ $tvshow->country }}</p>
                        <p class="mb-5 text-gray-200">Language: {{ $tvshow->language }}</p>
                        <p class="mb-5 text-gray-200">
                            Budget: <span class="font-bold text-black">Rs.</span>{{ $tvshow->budget }}
                        </p>
                        @if($tvshow->singer_male && $singer_male = $artist->find($tvshow->singer_male))
                            <p class="mb-5 text-gray-200"><strong>Singer Male:</strong> 
                                <a class="text-yellow-300" href="{{ route('artist.show', $singer_male->id) }}">{{ $singer_male->name }}</a>
                            </p>
                        @endif
                        @if($tvshow->singer_female && $singer_female = $artist->find($tvshow->singer_female))
                            <p class="mb-5 text-gray-200"><strong>Singer Female:</strong> 
                                <a class="text-yellow-300" href="{{ route('artist.show', $singer_female->id) }}">{{ $singer_female->name }}</a>
                            </p>
                        @endif
                        {{-- <p class="mb-5 text-gray-600">
                            Box Office: <span class="font-bold text-black">Rs.</span>{{ $tvshow->box_office }}
                        </p> --}}
                    </div>

                    <div class="w-full px-4 md:w-1/2">
                        <img src="{{ $tvshow->poster }}" alt="{{ $tvshow->title }}" class="w-full h-auto">
                    </div>

                    <div class="w-full px-4">
                        <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-100"><span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Cast</h3>
                        <ul class="mb-5 text-gray-600">
                            {{-- @foreach($tvshow->cast as $cast)
                                <li>{{ $cast->name }} as {{ $cast->character }}</li>
                            @endforeach --}}
                        </ul>

                        <div class="review">
                            <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-100"><span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Reviews</h3>
                            <div class="p-4 bg-gray-900 rounded">
                                <h1 class="font-bold text-xl">Post a Review</h1>
                            
                                <form action="{{ route('tv-shows.reviews.store', $tvshow) }}"  method="POST">
                                    @csrf
                                @if (session('error'))
                                    <div class="bg-red-100 border border-red-500 text-red-700 px-4 py-3 rounded relative" role="alert">
                                        <strong class="font-bold">{{ session('error') }}</strong>
                                    </div>
                                @endif
                            
                                @if ($errors->any())
                                    <div class="bg-red-100 border border-red-500 text-red-700 px-4 py-3 rounded relative" role="alert">
                                        <strong class="font-bold">Whoops! Something went wrong!</strong>
                                        <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                @endif
                                    <input type="hidden" name="tvshow_id" value="{{ $tvshow->id }}">
                                    <div class="mt-4">
                                        <x-input-label for="review_text" :value="__('Review')" />
                                        <x-textarea id="review_text" class="block mt-1 w-full text-black py-4" name="review_text" required>{{ old('review_text') }}</x-textarea>
                                        <x-input-error :messages="$errors->get('review_text')" class="mt-2" />
                                    </div>
                                    <div class="mt-4">
                                        <x-input-label for="rating" :value="__('Rating')" />
                                        <x-star-rating id="rating" class="block mt-1 w-full" name="rating" required></x-star-rating>
                                        <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                                        <x-input-submit class="my-6">Submit</x-input-submit>
                                </form>
                            </div>
                            <ul class="mb-5 text-gray-200">
                                <style>
                                    .paginate p{
                                        color:white;
                                        padding: 0 15px;
                                    }
                                </style>
                                {{-- Uncomment this when reviews data is available --}}
                                @foreach($reviews as $review)
                                    <li class="flex flex-col  items-start border-b border-gray-800 p-2 hover:bg-gray-800 transition-all">
                                        <div class="flex items-center  justify-between w-full mb-2">
                                            <i class="fa-solid fa-user-circle fa-2x text-yellow-400 mr-2"></i> <strong class="mr-2">{!! $review->user ? $review->user->name : '<span class="text-gray-500">[deleted account]</span>' !!}</strong>
                                            <p class="text-sm">{{ $review->review_text }}</p>
                                            <span class="text-xs text-gray-500 ml-auto">({{ $review->created_at->format('M d, Y') }})</span>
                                        </div>
                                        <small class="px-8"><i class='fa fa-star text-yellow-300 '></i> {{ $review->rating }} stars</small>
                                    </li>
                                @endforeach
                            </ul>
                            <span class='paginate text-white text-sm'>{{ $reviews->links() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
