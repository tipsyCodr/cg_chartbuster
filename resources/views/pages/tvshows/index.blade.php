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
        <ul class="mt-4">
            @foreach ($tvshows as $tvshow)
                <li
                    class="flex items-start justify-start gap-3 px-2 py-3 transition-all border-b border-gray-800 rounded hover:bg-gray-800 sm:gap-5">
                    <img src="{{ asset('storage/' . $tvshow->poster_image) }}" class="w-16 rounded-md sm:w-20" alt="">
                    <div class="flex min-w-0 flex-col">
                        <a href="{{ route('tv-show.show', $tvshow->slug) }}"
                            class="font-bold text-gray-100 hover:text-gray-300">
                            {{ $tvshow->title }}
                        </a>
                        <span class="text-xs text-gray-500 sm:text-sm">
                            Released on:
                            @if($tvshow->release_date)
                                {{ \Carbon\Carbon::parse($tvshow->release_date)->format($tvshow->is_release_year_only ? 'Y' : 'd M Y') }}
                            @else
                                N/A
                            @endif
                            @if(!empty($tvshow->duration) && !in_array($tvshow->duration, ['00:00', '00:00:00', '05:00', '00:05:00']))
                                Duration:
                                {{ $tvshow->duration }} mins
                            @endif
                        </span>
                        <small class="mt-1 text-xs text-gray-500">
                            <i class="text-xs text-yellow-300 fa fa-star" aria-hidden="true"></i>
                            4.3
                        </small>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>
</x-app-layout>
