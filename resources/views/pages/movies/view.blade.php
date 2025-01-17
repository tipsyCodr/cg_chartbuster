<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-100">
            {{ __('Movie') }}
        </h2>
    </x-slot>
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
                @if($movie->trailer_url != "" && $movie->trailer_url != " " )
                    {!! $movie->trailer_url !!}
                @elseif($movie->poster_image_landscape != "" && $movie->poster_image_landscape != " ")
                    <img class="w-full h-auto" src="{{ asset("storage/{$movie->poster_image_landscape}") }}" alt="">
                @endif
            </div>
            <div class="p-4 w-28 flex-shrink-1 content">
                <div class="h-30 py-1 overflow-hidden text-ellipsis whitespace-nowrap">
                    <h1 class="text-2xl font-bold">{{ $movie->title }}</h1>
                    <small class="text-gray-200">
                        <i class="text-xs text-yellow-300 fa fa-star" aria-hidden="true"></i>
                        {{ $movie->rating }} 4.3
                    </small> <br>
                    <small class="text-gray-200">Released: {{ date('Y', strtotime($movie->release_date)) }}</small><br> 
                    <small class="text-gray-200"><strong>{{ $movie->genre }}</strong></small> <br>
                    <small class="text-gray-200"><strong>{{ substr($movie->duration, 0, 5) }} </strong>mins</small> <br>
                </div>
                <div class="h-40 overflow-y-auto">
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
                        <h2 class="mb-5 text-2xl font-semibold leading-tight text-gray-100">{{ $movie->title }}</h2>
                        <p class="mb-5 text-gray-200"><strong>Region:</strong> {{ $movie->region }}</p>
                        <p class="mb-5 text-gray-200"><strong>CBFC:</strong> {{ $movie->cbfc }}</p>
                        <p class="mb-5 text-gray-200"><strong>Cinematographer:</strong> {{ $movie->cinematographer }}</p>
                        <p class="mb-5 text-gray-200"><strong>DOP:</strong> {{ $movie->dop }}</p>
                        <p class="mb-5 text-gray-200"><strong>Screen Play:</strong> {{ $movie->screen_play }}</p>
                        <p class="mb-5 text-gray-200"><strong>Writer Story Concept:</strong> {{ $movie->writer_story_concept }}</p>
                        <p class="mb-5 text-gray-200"><strong>Male Lead:</strong> {{ $movie->male_lead }}</p>
                        <p class="mb-5 text-gray-200"><strong>Female Lead:</strong> {{ $movie->female_lead }}</p>
                        <p class="mb-5 text-gray-200"><strong>Support Artists:</strong> {{ $movie->support_artists }}</p>
                        <p class="mb-5 text-gray-200"><strong>Producer:</strong> {{ $movie->producer }}</p>
                        <p class="mb-5 text-gray-200"><strong>Songs:</strong> {{ $movie->songs }}</p>
                        <p class="mb-5 text-gray-200"><strong>Singer Male:</strong> {{ $movie->singer_male }}</p>
                        <p class="mb-5 text-gray-200"><strong>Singer Female:</strong> {{ $movie->singer_female }}</p>
                        <p class="mb-5 text-gray-200"><strong>Lyrics:</strong> {{ $movie->lyrics }}</p>
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
                        <p class="mb-5 text-gray-200"><strong>Others:</strong> {{ $movie->others }}</p>
                    </div>
                    <div class="w-full px-4 md:w-1/2 " >
                        @if($movie->poster_image)
                            <img src="{{ asset('storage/'.$movie->poster_image) }}" alt="{{ $movie->title }}" class="w-full h-auto">
                        @endif
                    </div>
                    <div class="w-full px-4 md:w-1/2">
                        <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-100">Cast</h3>
                        <ul class="mb-5 text-gray-200">
                            {{-- Uncomment this when cast data is available
                            @foreach($movie->cast as $cast)
                                <li>{{ $cast->name }} as {{ $cast->character }}</li>
                            @endforeach --}}
                        </ul>
                        <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-100">Reviews</h3>
                        <ul class="mb-5 text-gray-200">
                            {{-- Uncomment this when reviews data is available
                            @foreach($movie->reviews as $review)
                                <li>
                                    <strong>{{ $review->user->name }}:</strong> {{ $review->content }}
                                    <span class="text-sm text-gray-500">({{ $review->created_at->format('M d, Y') }})</span>
                                </li>
                            @endforeach --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
