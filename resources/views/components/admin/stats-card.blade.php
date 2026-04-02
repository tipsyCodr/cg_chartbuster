@props([
    'label',
    'value',
    'icon' => null,
    'trend' => null,
    'trendUp' => true,
    'color' => 'blue'
])

@php
    $colors = [
        'blue' => 'bg-blue-50 text-blue-600',
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'indigo' => 'bg-indigo-50 text-indigo-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'rose' => 'bg-rose-50 text-rose-600',
        'purple' => 'bg-purple-50 text-purple-600',
    ];
    $colorClass = $colors[$color] ?? $colors['blue'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition-all duration-300 group']) }}>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $label }}</h3>
        <div class="p-2 rounded-xl {{ $colorClass }} group-hover:scale-110 transition-transform duration-300">
            @if($icon)
                <i class="{{ $icon }}"></i>
            @else
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            @endif
        </div>
    </div>
    
    <div>
        <p class="text-3xl font-black text-gray-800 tracking-tight" x-text="{{ $value }}"></p>
        
        @if($trend)
            <div class="mt-2 flex items-center space-x-1">
                <span class="text-xs font-bold {{ $trendUp ? 'text-emerald-600' : 'text-rose-600' }}">
                    {{ $trendUp ? '+' : '-' }}{{ $trend }}
                </span>
                <span class="text-[10px] text-gray-400 font-medium">vs last month</span>
            </div>
        @endif
        
        @if($slot->isNotEmpty())
            <div class="mt-2 text-xs text-gray-500 font-medium">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
