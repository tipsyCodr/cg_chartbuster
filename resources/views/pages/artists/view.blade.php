<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Artist Details') }}
        </h2>
    </x-slot>

    <div class="px-5 py-6">
        <!-- Artist Profile Section -->
        <div class="flex flex-col items-start gap-6 lg:flex-row">
            <!-- Artist Photo -->
            <div class="flex flex-col gap-4 md:flex-row">
                <img class="object-cover rounded-md shadow-md w-52 h-52"
                    src="{{ $artists->photo ? asset('storage/' . $artists->photo) : asset('images/placeholder.png') }}"
                    alt="{{ $artists->name }}">
                <div class="">
                    <h1 class="text-3xl font-bold text-gray-100">{{ $artists->name }}</h1>
                    @if($artists->cgcb_rating)
                        <div class="flex items-center justify-start">
                            <img class="m-1 " style="width:25px;height:25px;" src="{{ asset('images/badge.png') }}"
                                alt="CG Chartbusters Rating">
                            <p class="text-xs"> {{ $artists->cgcb_rating }} /10 Ratings</p>
                        </div>
                    @endif
                    @php
                        // $categoryIds = json_decode($artists->category, true) ?? [];
                        // $selectedCategories = \App\Models\ArtistCategory::whereIn('id', $categoryIds)->get();

                        $decoded = json_decode($artists->category, true);

                        // Normalize: make sure it's always an array
                        if (is_null($decoded)) {
                            $categoryIds = [];
                        } elseif (is_array($decoded)) {
                            $categoryIds = $decoded;
                        } else {
                            // if it's a single int/string, wrap it in array
                            $categoryIds = [$decoded];
                        }

                        $selectedCategories = collect();

                        if (!empty($categoryIds)) {
                            $selectedCategories = \App\Models\ArtistCategory::whereIn('id', $categoryIds)->get();
                        }
                    @endphp
                    <style>
                        .hide-scrollbar::-webkit-scrollbar {
                            display: none;
                            /* Chrome, Safari, Opera */
                        }

                        .hide-scrollbar {
                            -ms-overflow-style: none;
                            /* IE and Edge */
                            scrollbar-width: none;
                            /* Firefox */
                        }
                    </style>
                    @if($selectedCategories->isNotEmpty())
                        <div class="flex gap-3 py-2 overflow-x-auto hide-scrollbar max-w-[600px]">
                            @foreach ($selectedCategories as $cat)
                                <small
                                    class=" flex-1 text-nowrap w-fit px-2 py-1 bg-gray-700 text-white cursor-pointer hover:bg-gray-900 rounded">
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
                        <p class="text-gray-200">{{ \Carbon\Carbon::parse($artists->birth_date)->format('F j, Y') }}</p>
                    </div>
                    <!-- Biography -->
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-100">Biography</h3>
                        <p class="mt-2 text-gray-200">{{ $artists->bio }}</p>
                    </div>
                </div>
            </div>


        </div>
        <!-- Artist Movies Section -->
        <div class="mt-8">
            <h3 class="text-2xl font-semibold text-gray-100 mb-4">Movies</h3>

            @if($artists->movies->isEmpty())
                <p class="text-gray-400 italic">No movies found</p>
            @else
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-4 gap-6">
                    @foreach($artists->movies as $movie)
                        <a href="{{ route('movie.show', $movie->id) }}">
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
                                        {{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }}
                                    </p>
                                    {{-- Show Artist Category --}}
                                    @php
                                        $category = \App\Models\ArtistCategory::find($movie->pivot->artist_category_id);
                                    @endphp
                                    @if($category)
                                        <p class="text-indigo-400 text-xs mt-1">
                                            Role:
                                            <span class="px-2 py-1 bg-gray-700 text-white cursor-pointer hover:bg-gray-900 rounded">
                                                {{ $category->name }}
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
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