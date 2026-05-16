<div>
    <section class="my-5">
        <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"><span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Movies</h1>
        <div class="flex flex-row gap-6 px-12 py-4 overflow-x-auto scrollbar-hide sm:px-4">
            @foreach ($movies as $movie)
                <a href="{{ route('movie.show', $movie->slug) }}">
                    <div class="flex-shrink-0 mr-4 transition-all bg-gray-900 rounded-lg shadow-md last:mr-0 group">
                        <div class="relative min-w-40 max-w-40 sm:min-w-48 sm:max-w-48">
                            <img class="object-cover w-full h-56 sm:h-64 transition-all duration-300 rounded-t-lg group-hover:brightness-75"
                                src="{{ Storage::url($movie->poster_image) }}" alt="Movie Image">
                            <div class="rounded-b-lg bg-gray-900 px-3 py-3">
                                <div class="flex justify-start items-center gap-1 text-[10px] mb-2 text-gray-400">
                                    <img src="{{ asset('images/badge.png') }}" alt="Rating" class="w-3 h-3">
                                    <span>{{ $movie->cg_chartbusters_ratings }} / 10</span>
                                </div>
                                <h2 class="truncate text-xs font-bold text-white mb-3">
                                    {{ ucwords(strtolower($movie->title)) }}
                                </h2>
                                <a href="{{ route('movie.show', $movie->slug) }}" class="block w-full py-1.5 text-[10px] font-bold text-center text-white bg-gray-800 border border-gray-700 rounded-full hover:bg-yellow-500 hover:text-black hover:border-yellow-500 transition-all">Details</a>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</div>
