<x-app-layout>

    <section class="mt-9 mb-9">
        <h1 class="text-2xl font-bold">TV Shows</h1>
        <div class="mt-8 space-y-3">
            @foreach ($tvShows as $tvShow)
                <a href="{{ route('tv-show.show', $tvShow->slug) }}"
                    class="group block overflow-hidden rounded-lg border border-gray-800 bg-black/40 transition-colors hover:border-yellow-500/50 hover:bg-gray-800/40">
                    <div class="flex items-center">
                        <div class="w-24 h-32 shrink-0 sm:w-28 sm:h-36 md:w-32 md:h-44">
                            <img src="{{ asset('storage/'.$tvShow->poster_image) }}" alt="{{ $tvShow->title }}"
                                class="h-full w-full object-cover">
                        </div>
                        <div class="flex flex-1 flex-col justify-center gap-1 px-4 py-2">
                            <h3 class="line-clamp-1 text-base font-bold text-gray-100 group-hover:text-yellow-400">
                                {{ $tvShow->title }}
                            </h3>
                            <p class="line-clamp-1 text-xs text-gray-400">
                                {{ date('Y', strtotime($tvShow->release_date)) }}
                                @if(!empty($tvShow->duration) && !in_array($tvShow->duration, ['00:00', '00:00:00', '05:00', '00:05:00']))
                                    <span class="px-1 text-gray-600">•</span> {{ $tvShow->duration }} mins
                                @endif
                            </p>
                            <div class="flex items-center gap-2 text-xs">
                                <i class="fa-solid fa-star text-yellow-500 text-[10px]"></i>
                                <span class="font-bold text-white">4.3</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

</x-app-layout>