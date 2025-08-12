<x-app-layout>

    <section class="mt-9  min-h-[50vh]">
        <h1 class="text-2xl font-bold">Artists
            {{-- <span class='inline-block ms-5'>
                <form action="{{ route('artists.query') }}" method="GET" class="flex items-center justify-start gap-5" onchange="this.submit()">
                    <select name="genre" id="genre" class="px-4 py-2 bg-gray-800 border-gray-800 rounded text-white">
                        <option value="" class="text-white" {{ request()->query('genre') == '' ? 'selected' : '' }}>All</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" {{ request()->query('genre') == $genre->id ? 'selected' : '' }} class="text-white">{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </form>
            </span> --}}

        </h1>
        <ul class="mt-4">
            @foreach ($artists as $artist)
                <li class="flex items-center justify-start gap-5 px-2 py-2 transition-all border-b border-gray-800 rounded hover:bg-gray-800">
                    <img src="{{ asset('storage/'.$artist->photo) }}" class="w-20 rounded-md" alt="">
                    <div class="flex flex-col">
                        <a href="{{ route('artist.show', $artist) }}" class="font-bold text-gray-100 hover:text-gray-300">
                            {{ $artist->name }}
                        </a>
                        <span class="text-sm text-gray-500">
                            {{-- {{ date('Y', strtotime($artist->debut_date)) }} --}}
                            <p class="text-gray-400 text-xs">Born on:{{ \Carbon\Carbon::parse($artist->birth_date)->format('F j, Y') }}</p>
                        </span>
                        <small>{{$artist->city}}</small>
                        {{-- <small class="text-xs text-gray-500">
                            <i class="text-xs text-yellow-300 fa fa-star" aria-hidden="true"></i>
                            {{ $artist->cg_chartbusters_rating }}
                        </small> --}}
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

</x-app-layout>