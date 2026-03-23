<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Artist Details') }}
        </h2>
    </x-slot>

    <div class="px-3 py-6 sm:px-5">
        <!-- Artist Profile Section -->
        <div class="flex flex-col items-start gap-6 lg:flex-row">
            <!-- Artist Photo -->
            <div class="flex flex-col gap-4 md:flex-row">
                <img class="h-40 w-40 rounded-md object-cover shadow-md sm:h-52 sm:w-52"
                    src="{{ $artists->photo ? asset('storage/' . $artists->photo) : asset('images/placeholder.png') }}"
                    alt="{{ $artists->name }}">
                <div class="">
                    <h1 class="break-words text-2xl font-bold text-gray-100 sm:text-3xl">{{ $artists->name }}</h1>
                    @if($artists->cgcb_rating)
                        <div class="flex items-center justify-start">
                            <img class="m-1 " style="width:25px;height:25px;" src="{{ asset('images/badge.png') }}"
                                alt="CG Chartbusters Rating">
                            <p class="text-xs"> {{ $artists->cgcb_rating }} /10 Ratings</p>
                        </div>
                    @endif
                    @php
                        $categoryIds = $artists->category ?? [];
                        $selectedCategories = collect();

                        if (!empty($categoryIds)) {
                            // Ensure $categoryIds is an array even if it was miraculously a single value
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
                            {{ $artists->birth_date ? \Carbon\Carbon::parse($artists->birth_date)->format($artists->is_release_year_only ? 'Y' : 'F j, Y') : 'N/A' 
                            }}
                            {{-- {{ optional($artists->birth_date)->format('F j, Y') ?? 'N/A' }} --}}
                            {{-- {{ \Carbon\Carbon::parse($artists->birth_date)->format('F j, Y') }} --}}
                        </p>
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
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
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
