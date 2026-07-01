@props([
    'disabled' => false,
    'error' => false,
    'placeholder' => null,
])

<div class="relative group">
    <select {{ $disabled ? 'disabled' : '' }} 
        {{ $attributes->class([
            'appearance-none w-full px-4 py-3 border rounded-xl text-sm font-bold outline-none transition-all duration-200 pr-10',
            'bg-white border-gray-100 text-gray-700 hover:border-gray-200 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10' => !$error && !($attributes->has('class') && str_contains($attributes->get('class'), 'bg-gray-850')),
            'bg-gray-850 border-gray-700 text-white hover:border-gray-600 focus:border-yellow-500/50 focus:ring-4 focus:ring-yellow-500/10' => !$error && ($attributes->has('class') && str_contains($attributes->get('class'), 'bg-gray-850')),
            'border-rose-500 ring-4 ring-rose-500/10 focus:border-rose-600 focus:ring-rose-600/15' => $error,
            'bg-gray-50/50 cursor-not-allowed opacity-60' => $disabled
        ]) }}
    >
        @if($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>
    
    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
        <i class="fas fa-chevron-down text-[10px]"></i>
    </div>
</div>
