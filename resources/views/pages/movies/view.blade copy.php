<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-100">
            {{ __('Movie') }}
        </h2>
    </x-slot>
    @php
        $artist = new App\Models\Artist();
    @endphp
    <style>
        .hero {
            flex: 1;
            /* Make iframe take half the screen */
        }

        iframe {
            width: 100%;
            /* Make iframe responsive */
            height: 100%;
            /* Ensure iframe fills its container */
            aspect-ratio: 16 / 9;
            /* Maintain proper aspect ratio */
        }

        .hero,
        .content {
            min-width: 100%;
            /* Default to full width on small screens */
        }

        @media (min-width: 768px) {

            .hero,
            .content {
                min-width: 50%;
                /* Half width on medium+ screens */
            }
        }
    </style>

    <div class="px-5">
        <div class="flex flex-col overflow-hidden bg-gray-600 shadow-2xl rounded-xl shadow-gray-600 md:flex-row">
            <div class="flex-grow-1 hero">
                {{-- @if($movie->trailer_url != "" && $movie->trailer_url != " ")
                    {!! $movie->trailer_url !!}
                @elseif($movie->poster_image_landscape != "" && $movie->poster_image_landscape != " ")
                    <img class="w-full h-auto" src="{{ asset("storage/{$movie->poster_image_landscape}") }}" alt="">
                @endif --}}

                @if($movie->trailer_url != "" && $movie->trailer_url != " " && str_contains($movie->trailer_url,'http'))
                    {!! $movie->trailer_url !!}
                @elseif($movie->poster_image_landscape != "" && $movie->poster_image_landscape != " ")
                    <img class="w-full h-auto" src="{{ asset("storage/{$movie->poster_image_landscape}") }}" alt="">
                @elseif($movie->poster_image != "" && $movie->poster_image != " ")
                    <img class="w-full h-full object-cover" src="{{ asset('storage/'.$movie->poster_image) }}" alt="">
                @endif
            </div>
            <div class="p-4 w-28 flex-shrink-1 content">
                <div class="py-1 overflow-hidden h-30 text-ellipsis whitespace-nowrap">
                    <div class="flex gap-2">
                        <div class="overflow-hidden rounded-md poster_image">
                            @if($movie->poster_image != "" && $movie->poster_image != " ")
                                <img class="w-full max-w-[110px] object-cover h-full"
                                    src="{{ asset("storage/{$movie->poster_image}") }}" alt="">
                            @endif
                        </div>
                        <div class="">
                            <h1 class="text-2xl font-bold">{{ $movie->title }}</h1>
                            <small class="text-gray-200">
                                <i class="text-xs text-yellow-300 fa fa-star" aria-hidden="true"></i>
                                {{ $movie->rating }} 4.3
                            </small> <br>
                            <small class="text-gray-200">Released:
                                {{ date('Y', strtotime($movie->release_date)) }}</small><br>
                            <small class="text-gray-200"><strong>{{ $movie->genre }}</strong></small> <br>
                            <small class="text-gray-200"><strong>{{ substr($movie->duration, 0, 5) }}
                                </strong>mins</small> <br>
                        </div>
                    </div>
                </div>
                <div class="h-40 overflow-y-auto">
                    <p><strong>Plot:</strong></p>
                    <p class="text-gray-200">{{ $movie->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-5 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full px-4 md:w-1/2">
                        <h2 class="mb-5 text-xl font-semibold leading-tight"><span
                                class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> About:</h2>
                                <h2 class="mb-5 text-2xl font-semibold leading-tight text-gray-100">{{ $movie->title }}</h2>
                                {{-- <p class="mb-5 text-gray-200">{{ $movie->description }}</p> --}}
                        <p class="mb-5 text-gray-200"><strong>Language:</strong> {{ ucwords($movie->region) }}</p>
                        <p class="mb-5 text-gray-200"><strong>CBFC:</strong> {{ $movie->cbfc }}</p>

                        <div class="">
                            
                        {{-- <p class="mb-5 text-gray-200"><strong>Cinematographer:</strong> {{ $movie->cinematographer
                            }}</p>
                        <p class="mb-5 text-gray-200"><strong>DOP:</strong> {{ $movie->dop }}</p>
                        <p class="mb-5 text-gray-200"><strong>Screen Play:</strong> {{ $movie->screen_play }}</p>
                        <p class="mb-5 text-gray-200"><strong>Writer Story Concept:</strong> {{
                            $movie->writer_story_concept }}</p>
                        <p class="mb-5 text-gray-200"><strong>Male Lead:</strong> {{ $movie->male_lead }}</p>
                        <p class="mb-5 text-gray-200"><strong>Female Lead:</strong> {{ $movie->female_lead }}</p>
                        <p class="mb-5 text-gray-200"><strong>Support Artists:</strong> {{ $movie->support_artists }}
                        </p>
                        <p class="mb-5 text-gray-200"><strong>Producer:</strong> {{ $movie->producer }}</p>
                        <p class="mb-5 text-gray-200"><strong>Songs:</strong> {{ $movie->songs }}</p> --}}
                        {{-- @if($movie->singer_male && $singer_male = $artist->find($movie->singer_male))
                        <p class="mb-5 text-gray-200"><strong>Singer Male:</strong>
                            <a class="text-yellow-300" href="{{ route('artist.show', $singer_male->id) }}">{{
                                $singer_male->name }}</a>
                        </p>
                        @endif
                        @if($movie->singer_female && $singer_female = $artist->find($movie->singer_female))
                        <p class="mb-5 text-gray-200"><strong>Singer Female:</strong>
                            <a class="text-yellow-300" href="{{ route('artist.show', $singer_female->id) }}">{{
                                $singer_female->name }}</a>
                        </p>
                        @endif --}}
                        {{-- <p class="mb-5 text-gray-200"><strong>Lyrics:</strong> {{ $movie->lyrics }}</p>
                        <p class="mb-5 text-gray-200"><strong>Composition:</strong> {{ $movie->composition }}</p>
                        <p class="mb-5 text-gray-200"><strong>Mix Master:</strong> {{ $movie->mix_master }}</p>
                        <p class="mb-5 text-gray-200"><strong>Music:</strong> {{ $movie->music }}</p>
                        <p class="mb-5 text-gray-200"><strong>Recordists:</strong> {{ $movie->recordists }}</p>
                        <p class="mb-5 text-gray-200"><strong>Audio Studio:</strong> {{ $movie->audio_studio }}</p>
                        <p class="mb-5 text-gray-200"><strong>Editor:</strong> {{ $movie->editor }}</p>
                        <p class="mb-5 text-gray-200"><strong>Video Studio:</strong> {{ $movie->video_studio }}</p>
                        <p class="mb-5 text-gray-200"><strong>Poster Logo:</strong> {{ $movie->poster_logo }}</p>
                        <p class="mb-5 text-gray-200"><strong>VFX:</strong> {{ $movie->vfx }}</p>
                        <p class="mb-5 text-gray-200"><strong>Make Up:</strong> {{ $movie->make_up }}</p>
                        <p class="mb-5 text-gray-200"><strong>Drone:</strong> {{ $movie->drone }}</p>
                        <p class="mb-5 text-gray-200"><strong>Others:</strong> {{ $movie->others }}</p> --}}
                        </div>
                    </div>
                    {{-- <div class="w-full px-4 md:w-1/2 ">
                        @if($movie->poster_image)
                            <img src="{{ asset('storage/' . $movie->poster_image) }}" alt="{{ $movie->title }}"
                                class="w-full h-auto">
                        @endif
                    </div> --}}
                    <div class="w-full px-4 py-4">
                        <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-100"><span
                                class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Cast</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mb-5 text-gray-200">
                            {{-- Uncomment this when cast data is available --}}
                            @foreach ($movie->artists as $artist)
                                <a href="{{ route('artist.show',$artist->id) }}" class="cast-member flex items-center bg-gray-800 rounded-lg p-4 hover:bg-gray-700">
                                    <img src="{{ asset('storage/' . $artist->photo) }}" alt="{{ $artist->name }}"
                                        class="w-16 h-16 rounded-full object-cover border" />
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-100">{{ $artist->name }}</h4>

                                        @php
                                            $roleId = $artist->pivot->artist_category_id;
                                            $roleName = \App\Models\ArtistCategory::find($roleId)?->name ?? 'Unknown';
                                        @endphp

                                        <p class="text-sm text-gray-500">{{ $roleName }}</p>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                        <div class="review" id="review">
                            <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-100"><span
                                    class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Reviews
                            </h3>
                            <div class="p-4 bg-gray-900 rounded max-w-2xl">
                                <h1 class="text-xl font-bold">Post a Review</h1>

                                <form action="{{ route('movies.reviews.store', $movie) }}" method="POST">
                                    @csrf
                                    @if (session('error'))
                                        <div class="relative px-4 py-3 text-red-700 bg-red-100 border border-red-500 rounded"
                                            role="alert">
                                            <strong class="font-bold">{{ session('error') }}</strong>
                                        </div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="relative px-4 py-3 text-red-700 bg-red-100 border border-red-500 rounded"
                                            role="alert">
                                            <strong class="font-bold">Whoops! Something went wrong!</strong>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                    <div class="mt-4">
                                        <x-input-label for="review_text" :value="__('Review')" />
                                        <x-textarea id="review_text" class="block w-full py-4 mt-1 text-black"
                                            name="review_text" required>{{ old('review_text') }}</x-textarea>
                                        <x-input-error :messages="$errors->get('review_text')" class="mt-2" />
                                    </div>
                                    <div class="mt-4">
                                        <x-input-label for="rating" :value="__('Rating')" />
                                        <x-star-rating id="rating" class="block w-full mt-1" name="rating"
                                            required></x-star-rating>
                                        <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                                        <x-input-submit class="my-6">Submit</x-input-submit>
                                </form>
                            </div>
                            <ul class="mb-5 text-gray-200">
                                <style>
                                    .paginate p {
                                        color: white;
                                        padding: 0 15px;
                                    }
                                </style>
                                {{-- Uncomment this when reviews data is available --}}
                                @foreach($reviews as $review)
                                    <li
                                        class="flex flex-col items-start p-2 transition-all border-b border-gray-800 hover:bg-gray-800">
                                        <div class="flex items-center justify-between w-full mb-2">
                                            <i class="mr-2 text-yellow-400 fa-solid fa-user-circle fa-2x"></i> <strong
                                                class="mr-2">{!! $review->user ? $review->user->name : '<span class="text-gray-500">[deleted account]</span>' !!}</strong>
                                            <p class="text-sm">{{ $review->review_text }}</p>
                                            <span
                                                class="ml-auto text-xs text-gray-500">({{ $review->created_at->format('M d, Y') }})</span>
                                        </div>
                                        <small class="px-8"><i class='text-yellow-300 fa fa-star '></i>
                                            {{ $review->rating }} stars</small>
                                    </li>
                                @endforeach
                            </ul>
                            <span class='text-sm text-white paginate'>{{ $reviews->links() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>