<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-100">
            {{ __('Movie') }}
        </h2>
    </x-slot>
    <div class="px-5">
        <div class="flex gap-5">
            <img class='w-52' src="{{ asset('storage/'.$song->poster_image) }}"  alt="">
            <div>
                <h1 class="text-2xl font-bold">{{ $song->title }}</h1>
                <p class="text-gray-200">{{ $song->description }}</p>
                <p class="text-gray-200">{{ $song->genre }}</p>
                <p class="text-gray-200">{{ $song->duration }} mins</p>
                <p class="text-gray-200">{{ date('Y', strtotime($song->release_date)) }}</p>
                <p class="text-gray-200">
                    <i class="text-xs text-yellow-300 fa fa-star" aria-hidden="true"></i>
                    {{ $song->rating }} 4.3
                </p>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-5 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full px-4 md:w-1/2">
                        <h2 class="mb-5 text-2xl font-semibold leading-tight text-gray-100">{{ $song->title }}</h2>
                        <p class="mb-5 text-gray-200">{{ $song->description }}</p>
                        <p class="mb-5 text-gray-200">Rating: {{ $song->rating }}</p>
                        <p class="mb-5 text-gray-200">Release Date: {{ $song->release_date }}</p>
                        <p class="mb-5 text-gray-200">Genre: {{ $song->genre }}</p>
                        <p class="mb-5 text-gray-200">Duration: {{ $song->duration }} minutes</p>
                        <p class="mb-5 text-gray-200">Director: {{ $song->director }}</p>
                        <p class="mb-5 text-gray-200">Writer: {{ $song->writer }}</p>
                        <p class="mb-5 text-gray-200">Producer: {{ $song->producer }}</p>
                        <p class="mb-5 text-gray-200">Production Company: {{ $song->production_company }}</p>
                        <p class="mb-5 text-gray-200">Country: {{ $song->country }}</p>
                        <p class="mb-5 text-gray-200">Language: {{ $song->language }}</p>
                        <p class="mb-5 text-gray-200">Budget: <span class="font-bold text-black">Rs.</span>{{ $song->budget }}</p>
                        <p class="mb-5 text-gray-200">Box Office: <span class="font-bold text-black">Rs.</span>{{ $song->box_office }}</p>
                    </div>
                    <div class="w-full px-4 md:w-1/2">
                        <img src="{{ asset('storage/'.$song->poster_image) }}"  alt="{{ $song->title }}" class="w-full h-auto">
                    </div>

</x-app-layout>
<div class="w-full px-4 md:w-1/2">
    <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-100">Cast</h3>
    <ul class="mb-5 text-gray-200">
        {{-- @foreach($song->cast as $cast)
            <li>{{ $cast->name }} as {{ $cast->character }}</li>
        @endforeach --}}
    </ul>
    <h3 class="mb-5 text-xl font-semibold leading-tight text-gray-100">Reviews</h3>
    <ul class="mb-5 text-gray-200">
        {{-- @foreach($song->reviews as $review)
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