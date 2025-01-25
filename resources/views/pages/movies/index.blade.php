<x-app-layout>

    <section class="pb-10 mt-10  min-h-[50vh]">
        <h1 class="text-2xl font-bold">
            Movies 

            <span class='inline-block ms-5'>
                <form action="{{ route('movies.query') }}" method="GET" class="flex items-center justify-start gap-5" onchange="this.submit()">
                    <select name="genre" id="genre" class="px-4 py-2 bg-gray-800 border-gray-800 rounded text-white">
                        <option value="" class="text-white" {{ request()->query('genre') == '' ? 'selected' : '' }}>All</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" {{ request()->query('genre') == $genre->id ? 'selected' : '' }} class="text-white">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </form>
            </span>
            
        </h1>
        <ul class="mt-4">
            @foreach ($movies as $movie)
                <li class="flex items-center justify-start gap-5 px-2 py-2 transition-all border-b border-gray-800 rounded hover:bg-gray-800">
                    <img src="{{ asset('storage/'.$movie->poster_image) }}" class="w-20 rounded-md" alt="">
                    <div class="flex flex-col">
                        <a href="{{ route('movie.show', $movie) }}" class="font-bold text-gray-100 hover:text-gray-300">
                            {{ $movie->title }}
                        </a>
                        <span class="text-sm text-gray-500">
                            {{ date('Y', strtotime($movie->release_date)) }}
                            {{ $movie->duration }} mins
                        </span>
                        <small class="text-xs text-gray-500">
                            <i class="text-xs text-yellow-300 fa fa-star" aria-hidden="true"></i>
                            4.3
                        </small>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

</x-app-layout>