<x-app-layout>
    @section('meta_title', 'Production Houses - CG Chartbusters')
    @section('meta_description', 'Browse all production houses on CG Chartbusters. Explore studios, their movies, songs, and web series.')

    <div class="container mx-auto max-w-7xl px-3 py-8 sm:px-4">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight flex items-center gap-3">
                <span class="w-1.5 h-8 bg-yellow-500 rounded inline-block"></span>
                Production Houses
            </h1>
            <p class="mt-2 text-gray-400 text-sm">Discover studios and production companies behind your favourite content</p>
        </div>

        {{-- Grid --}}
        @if($productionHouses->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center mb-4">
                    <i class="fas fa-building text-2xl text-gray-600"></i>
                </div>
                <p class="text-gray-400 font-medium">No production houses found yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($productionHouses as $ph)
                    <a href="{{ route('production-house.show', $ph->slug) }}"
                       class="group relative flex flex-col bg-gray-800/50 border border-gray-700/50 rounded-2xl overflow-hidden hover:border-yellow-500/40 hover:bg-gray-800/80 transition-all duration-300 shadow-lg hover:shadow-yellow-500/10 hover:-translate-y-0.5">

                        {{-- Banner --}}
                        <div class="h-28 w-full overflow-hidden bg-gray-900 relative">
                            @if($ph->banner_image)
                                <img src="{{ asset('storage/' . $ph->banner_image) }}"
                                     alt="{{ $ph->name }} banner"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-60">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900"></div>
                            @endif

                            {{-- Badges --}}
                            <div class="absolute top-2 right-2 flex gap-1.5">
                                @if($ph->is_verified)
                                    <span class="inline-flex items-center gap-1 bg-blue-500/90 text-white text-[9px] font-black uppercase tracking-widest px-1.5 py-0.5 rounded-full">
                                        <i class="fas fa-check-circle text-[8px]"></i> Verified
                                    </span>
                                @endif
                                @if($ph->is_featured)
                                    <span class="inline-flex items-center gap-1 bg-yellow-500/90 text-black text-[9px] font-black uppercase tracking-widest px-1.5 py-0.5 rounded-full">
                                        <i class="fas fa-star text-[8px]"></i> Featured
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Logo + Name --}}
                        <div class="px-4 pb-4 pt-0 flex-1 flex flex-col">
                            <div class="flex items-end gap-3 -mt-6 mb-3">
                                <div class="w-14 h-14 rounded-xl border-2 border-gray-700 bg-gray-900 overflow-hidden shadow-lg shrink-0">
                                    @if($ph->photo)
                                        <img src="{{ asset('storage/' . $ph->photo) }}"
                                             alt="{{ $ph->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-600">
                                            <i class="fas fa-building text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 pb-1">
                                    <h2 class="text-sm font-black text-white truncate leading-tight group-hover:text-yellow-400 transition-colors">
                                        {{ $ph->name }}
                                    </h2>
                                    @if($ph->city)
                                        <p class="text-[10px] text-gray-500 truncate mt-0.5">
                                            <i class="fas fa-map-marker-alt mr-1 text-[8px]"></i>{{ $ph->city }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Stats --}}
                            <div class="mt-auto grid grid-cols-3 gap-1 pt-3 border-t border-gray-700/50">
                                <div class="text-center">
                                    <p class="text-base font-black text-yellow-400">{{ $ph->produced_movies_count }}</p>
                                    <p class="text-[9px] text-gray-500 uppercase tracking-wider font-bold">Movies</p>
                                </div>
                                <div class="text-center border-x border-gray-700/50">
                                    <p class="text-base font-black text-yellow-400">{{ $ph->produced_songs_count }}</p>
                                    <p class="text-[9px] text-gray-500 uppercase tracking-wider font-bold">Songs</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-base font-black text-yellow-400">{{ $ph->produced_tv_shows_count }}</p>
                                    <p class="text-[9px] text-gray-500 uppercase tracking-wider font-bold">Shows</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
