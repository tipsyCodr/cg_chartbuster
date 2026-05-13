<x-app-layout>

    <section class="pb-10 mt-8 min-h-[50vh]">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold">Movies</h1>
            <form action="{{ route('movies.query') }}" method="GET" class="w-full sm:w-auto" onchange="this.submit()">
                <select name="genre" id="genre"
                    class="w-full px-4 py-2 bg-gray-800 border-gray-800 rounded text-white sm:min-w-52">
                    <option value="" class="text-white" {{ request()->query('genre') == '' ? 'selected' : '' }}>All
                    </option>
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}" {{ request()->query('genre') == $genre->id ? 'selected' : '' }}
                            class="text-white">{{ $genre->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="mt-8 space-y-3">
            @foreach ($movies as $movie)
                @php
                    $year = $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y') : 'N/A';
                    $cbfc = $movie->cbfc ?: 'NA';
                    $genresText = $movie->genres->pluck('name')->implode(', ') ?: 'Genres';
                    $votes = $movie->reviews_count ?? 0;
                @endphp
                <a href="{{ route('movie.show', $movie->slug) }}"
                    class="group block overflow-hidden rounded-lg border border-gray-800 bg-black/40 transition-colors hover:border-yellow-500/50 hover:bg-gray-800/40">
                    <div class="flex items-center">
                        <div class="w-24 h-32 shrink-0 sm:w-28 sm:h-36 md:w-32 md:h-44">
                            @if(!empty($movie->poster_image))
                                <img src="{{ asset('storage/' . $movie->poster_image) }}" alt="{{ $movie->title }}"
                                    class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gray-700 text-[10px] text-gray-300">
                                    Poster
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-1 px-4 py-2">
                            <h3 class="line-clamp-1 text-base font-bold text-gray-100 group-hover:text-yellow-400">
                                {{ $movie->title }}
                            </h3>
                            <p class="line-clamp-1 text-xs text-gray-400">
                                {{ $year }} <span class="px-1 text-gray-600">•</span> {{ $cbfc }} <span class="px-1 text-gray-600">•</span> {{ $genresText }}
                            </p>
                            <div class="flex items-center gap-2 text-xs">
                                <i class="fa-solid fa-star text-yellow-500 text-[10px]"></i>
                                <span class="font-bold text-white">{{ $movie->cg_chartbusters_ratings ?? 0 }}/10</span>
                                <span class="text-gray-500">({{ $votes }} Votes)</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

</x-app-layout>
