@props(['index' => null, 'route', 'image', 'title', 'rating'])

<div {{ $attributes->merge(['class' => 'group/card relative bg-gray-900/50 rounded-xl border border-white/5 hover:border-yellow-500/30 transition-all duration-300 flex flex-col']) }}>
    {{-- Ranking Number - Outside on the left --}}
    @if(isset($index))
        <span class="absolute -left-8 -top-3 md:-left-12 bottom-4 z-30 font-black text-yellow-500 text-7xl md:text-7xl not-italic select-none drop-shadow-[4px_0_8px_rgba(0,0,0,0.6)] transform group-hover/card:scale-105  group-hover/card:translate-y-2 transition-transform pointer-events-none">
            {{ $index }}
        </span>
    @endif

    {{-- Poster Image --}}
    <div class="relative aspect-[2/3] w-full overflow-hidden rounded-t-xl">
        <img class="object-cover w-full h-full transform group-hover/card:scale-105 transition-transform duration-500"
            src="{{ $image }}" alt="{{ $title }}">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
    </div>

    {{-- Content Area Below Poster --}}
    <div class="p-4 bg-gray-900/40 relative z-20 flex-1 flex flex-col justify-end rounded-b-xl overflow-hidden">
        {{-- Rating --}}
        <div class="flex items-center gap-1.5 mb-1">
            <img src="{{ asset('images/badge.png') }}" class="w-4 h-4" alt="Rating">
            <span class="text-xs font-bold text-gray-200">{{ $rating }} / 10</span>
        </div>

        {{-- Title --}}
        <h2 class="text-sm font-extrabold text-white line-clamp-1">
            {{ $title }}
        </h2>
    </div>

    {{-- Full Card Link --}}
    <a href="{{ $route }}" class="absolute inset-0 z-40 cursor-pointer"></a>
</div>
