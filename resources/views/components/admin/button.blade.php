@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null
])

@php
    $variants = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 shadow-sm shadow-blue-200 focus:ring-blue-500',
        'secondary' => 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50 focus:ring-gray-200',
        'danger' => 'bg-rose-500 text-white hover:bg-rose-600 shadow-sm shadow-rose-200 focus:ring-rose-400',
        'success' => 'bg-emerald-500 text-white hover:bg-emerald-600 shadow-sm shadow-emerald-200 focus:ring-emerald-400',
        'ghost' => 'bg-transparent text-gray-500 hover:bg-gray-100 focus:ring-gray-100',
    ];

    $sizes = [
        'xs' => 'px-2 py-1 text-[10px] font-bold uppercase',
        'sm' => 'px-3 py-1.5 text-xs font-semibold',
        'md' => 'px-4 py-2 text-sm font-bold',
        'lg' => 'px-6 py-3 text-base font-black',
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<button {{ $attributes->merge(['class' => "inline-flex items-center justify-center transition-all duration-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 $variantClass $sizeClass"]) }}>
    @if($icon)
        <i class="{{ $icon }} {{ $slot->isNotEmpty() ? 'mr-2' : '' }}"></i>
    @endif
    {{ $slot }}
</button>
