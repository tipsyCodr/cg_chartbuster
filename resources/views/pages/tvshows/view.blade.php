<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('TV Shows') }}
        </h2>
    </x-slot>

    <div class="px-5">
        <div class="flex gap-5">
            <img class='w-52' src="{{ asset('storage/'.$tvshow->poster_image) }}" alt="">
            <div>
                <h1 class="text-2xl font-bold">{{ $tvshow->title }}</h1>
                <p class="text-gray-600">{{ $tvshow->description }}</p>
                <p class="text-gray-600">{{ $tvshow->genre }}</p>
                <p class="text-gray-600">{{ $tvshow->duration }} mins</p>
                <p class="text-gray-600">{{ date('Y', strtotime($tvshow->release_date)) }}</p>
                <p class="text-gray-600">
                    <i class="text-xs text-yellow-300 fa fa-star" aria-hidden="true"></i>
                    {{ $tvshow->rating }}
                </p>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-5 overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full px-4 md:w-1/2">
                        <h2 class="mb-5 text-2xl font-semibold leading-tight text-gray-800">{{ $tvshow->title }}</h2>
                        <p class="mb-5 text-gray-600">{{ $tvshow->description }}</p>
                        <p class="mb-5 text-gray-600">Rating: {{ $tvshow->rating }}</p>
                        <p class="mb-5 text-gray-600">Release Date: {{ $tvshow->release_date }}</p>
                        <p class="mb-5 text-gray-600">Genre: {{ $tvshow->genre }}</p>
                        <p class="mb-5 text-gray-600">Duration: {{ $tvshow->duration }} minutes</p>
                        <p class="mb-5 text-gray-600">Director: {{ $tvshow->director }}</p>
                        <p class="mb-5 text-gray-600">Writer: {{ $tvshow->writer }}</p>
                        <p class="mb-5 text-gray-600">Producer: {{ $tvshow->producer }}</p>
                        <p class="mb-5 text-gray-600">Production Company: {{ $tvshow->production_company }}</p>
                        <p class="mb-5 text-gray-600">Country: {{ $tvshow->country }}</p>
                        <p class="mb-5 text-gray-600">Language: {{ $tvshow->language }}</p>
                        <p class="mb-5 text-gray-600">
                            Budget: <span class="font-bold text-black">Rs.</span>{{ $tvshow->budget }}
                        </p>
                        <p class="mb-5 text-gray-600">
                            Box Office: <span class="font-bold text-black">Rs.</span>{{ $tvshow->box_office }}
                        </p>
                    </div>

                    <div class="w-full px-4 md:w-1/2">
                        <img src="{{ $tvshow->poster }}" alt="{{ $tvshow->title }}" class="w-full h-auto">
                    </div>

                    <div class="w-full px-4">
                        <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-800">Cast</h3>
                        <ul class="mb-5 text-gray-600">
                            {{-- @foreach($tvshow->cast as $cast)
                                <li>{{ $cast->name }} as {{ $cast->character }}</li>
                            @endforeach --}}
                        </ul>

                        <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-800">Reviews</h3>
                        <ul class="mb-5 text-gray-600">
                            {{-- @foreach($tvshow->reviews as $review)
                                <li>
                                    <strong>{{ $review->user->name }}:</strong> {{ $review->content }}
                                    <span class="text-sm text-gray-500">
                                        ({{ $review->created_at->format('M d, Y') }})
                                    </span>
                                </li>
                            @endforeach --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
