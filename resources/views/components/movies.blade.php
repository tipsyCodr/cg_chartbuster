<div>
    <section class="my-5">
        <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"><span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Movies</h1>
        <div class="flex flex-row gap-2 px-4 py-4 overflow-x-auto scrollbar-hide">
            @foreach ($movies as $movie)
                <a href="{{ route('movie.show', $movie->slug) }}">
                    <div class="flex-shrink-0 mr-4 transition-all bg-gray-900 rounded-lg shadow-md last:mr-0 ">
                        <div class="relative min-w-48 max-w-48">
                            <img class="object-cover w-full h-56 transition-all duration-300 rounded-t-lg hover:brightness-90"
                                src="{{ Storage::url($movie->poster_image) }}" alt="Movie Image">
                            <div class="px-4 py-4 bg-gray-900 rounded-b-lg h-30">
                                <div class="flex justify-start items-center gap-1 text-xs mb-4 text-gray-300">
                                    <img src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating" class="w-4 h-4">
                                    <span>{{ $movie->cg_chartbusters_ratings }} / 10 Ratings</span>
                                </div>
                                <h2 class="py-6 overflow-hidden text-sm font-normal text-white normal-case w-38 text-nowrap text-ellipsis">
                                    {{ ucwords(strtolower($movie->title)) }}
                                </h2>
                                <a href="{{ route('movie.show', $movie->slug) }}" class="block w-full px-2 py-2 my-2 font-bold text-center text-white bg-gray-700 rounded-full hover:bg-gray-600 active:bg-gray-500 ">Details</a>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</div>
