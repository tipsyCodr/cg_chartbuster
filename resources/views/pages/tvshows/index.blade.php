<x-app-layout>
    <section class="mt-8 min-h-[50vh]">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold">TV Shows</h1>
            <form action="{{ route('tv-shows.query') }}" method="GET" class="w-full sm:w-auto" onchange="this.submit()">
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
        <div class="mt-8 space-y-4">
            @foreach ($tvshows as $tvshow)
                @php
                    $year = $tvshow->release_date ? \Carbon\Carbon::parse($tvshow->release_date)->format('Y') : 'N/A';
                    $cbfc = $tvshow->cbfc ?: 'NA';
                    $genresText = $tvshow->genres->pluck('name')->implode(', ') ?: 'Genres';
                    $votes = $tvshow->reviews_count ?? 0;
                @endphp
                <a href="{{ route('tv-show.show', $tvshow->slug) }}"
                    class="group block overflow-hidden rounded-xl border border-gray-600/70 bg-black transition-colors hover:border-yellow-400/70">
                    <div class="flex min-h-40">
                        <div class="w-28 shrink-0 sm:w-36 md:w-44">
                            @if(!empty($tvshow->poster_image))
                                <img src="{{ asset('storage/' . $tvshow->poster_image) }}" alt="{{ $tvshow->title }}"
                                    class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gray-700 text-sm text-gray-300">
                                    Poster
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-3 px-4 py-4 sm:px-5">
                            <h3 class="line-clamp-1 text-xl font-bold uppercase tracking-wide text-gray-100 sm:text-3xl">
                                {{ $tvshow->title }}
                            </h3>
                            <p class="line-clamp-1 text-sm text-gray-300 sm:text-2xl/none sm:tracking-wide">
                                {{ $year }} <span class="px-2">•</span> {{ $cbfc }} <span class="px-2">•</span> {{ $genresText }}
                            </p>
                            <div class="flex items-center gap-2 text-sm sm:text-2xl/none">
                                <i class="fa-solid fa-star text-yellow-400"></i>
                                <span class="font-bold text-white">{{ $tvshow->cg_chartbusters_ratings ?? 0 }}/10</span>
                                <span class="ml-4 text-gray-300">({{ $votes }} Votes)</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</x-app-layout>
