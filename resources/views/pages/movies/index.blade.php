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
        <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 sm:gap-6">
            @foreach ($movies as $movie)
                <div class="group relative flex flex-col overflow-hidden rounded-xl bg-gray-800 shadow-lg transition-all hover:-translate-y-2 hover:shadow-2xl">
                    <a href="{{ route('movie.show', $movie->slug) }}" class="relative aspect-[2/3] overflow-hidden">
                        <img src="{{ asset('storage/' . $movie->poster_image) }}" 
                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" 
                             alt="{{ $movie->title }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 transition-opacity group-hover:opacity-100">
                            <div class="absolute bottom-2 left-2 right-2">
                                <button class="w-full rounded-md bg-yellow-500 py-2 text-xs font-bold text-black shadow-lg">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </a>
                    <div class="flex flex-1 flex-col p-3">
                        <h3 class="line-clamp-1 text-sm font-bold text-white sm:text-base">
                            <a href="{{ route('movie.show', $movie->slug) }}" class="hover:text-yellow-400">
                                {{ $movie->title }}
                            </a>
                        </h3>
                        <div class="mt-1 flex items-center justify-between">
                            <span class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">
                                {{ $movie->release_date ? \Carbon\Carbon::parse($movie->release_date)->format('Y') : 'N/A' }}
                            </span>
                            <div class="flex items-center gap-1">
                                <i class="fa-solid fa-star text-[10px] text-yellow-400"></i>
                                <span class="text-[10px] font-bold text-gray-200">{{ $movie->cg_chartbusters_ratings }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</x-app-layout>
