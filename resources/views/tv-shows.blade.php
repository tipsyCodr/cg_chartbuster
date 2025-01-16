<x-app-layout>

    <section class="mt-9 mb-9">
        <h1 class="text-2xl font-bold">TV Shows</h1>
        <ul class="mt-4">
            @foreach ($tvShows as $tvShow)
                <li class="flex items-center justify-start gap-5 border-b border-gray-800 py-2 px-2 rounded hover:bg-gray-800 transition-all">
                    <img src="{{ asset('storage/'.$tvShow->poster_image) }}" class="w-20 rounded-md" alt="">
                    <div class="flex flex-col">
                        <a href="{{ route('tv-show.show', $tvShow) }}" class="text-gray-100 hover:text-gray-300">
                            {{ $tvShow->title }}
                        </a>
                        <span class="text-gray-500 text-sm">
                            {{ date('Y', strtotime($tvShow->release_date)) }}
                            {{ $tvShow->duration }} mins
                        </span>
                        <small class="text-gray-500 text-xs">
                            <i class="fa fa-star text-yellow-300 text-xs" aria-hidden="true"></i>
                            4.3
                        </small>
                    </div>
                </li>
            @endforeach
        </ul>
    </section>

</x-app-layout>