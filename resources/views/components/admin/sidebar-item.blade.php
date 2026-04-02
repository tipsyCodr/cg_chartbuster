@props([
    'href',
    'active' => false,
    'icon' => null,
])

<li>
    <a href="{{ $href }}" @class([
        'group flex items-center px-4 py-3 text-sm font-bold transition-all duration-200 rounded-2xl',
        'bg-blue-600 text-white shadow-md shadow-blue-200 active-nav' => $active,
        'text-gray-500 hover:bg-blue-50 hover:text-blue-600' => !$active,
    ])>
        @if($icon)
            <div @class([
                'mr-3 p-2 rounded-xl transition-all duration-200',
                'bg-blue-500 text-white' => $active,
                'bg-gray-50 text-gray-400 group-hover:bg-white group-hover:text-blue-500 group-hover:shadow-sm' => !$active,
            ])>
                <i class="{{ $icon }} text-base"></i>
            </div>
        @endif
        <span class="flex-1">{{ $slot }}</span>
        
        @if($active)
            <div class="w-1.5 h-1.5 rounded-full bg-white ml-2"></div>
        @endif
    </a>
</li>
