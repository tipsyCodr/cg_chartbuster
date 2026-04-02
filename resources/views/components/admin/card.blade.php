@props(['title' => null, 'footer' => null, 'header' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300']) }}>
    @if($title || $header ?? false)
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            @if($title)
                <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $title }}</h3>
            @else
                {{ $header }}
            @endif
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            {{ $footer }}
        </div>
    @endif
</div>
