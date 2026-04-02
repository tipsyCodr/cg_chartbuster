@props([
    'title' => null,
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm']) }}>
    @if($title || $description)
        <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/30">
            @if($title)
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-wider">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="mt-1 text-xs text-gray-400 font-bold uppercase tracking-widest">{{ $description }}</p>
            @endif
        </div>
    @endif
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{ $slot }}
        </div>
    </div>
</div>
