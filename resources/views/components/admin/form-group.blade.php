@props([
    'label' => null,
    'for' => null,
    'required' => false,
    'error' => null,
    'help' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if($label)
        <label for="{{ $for }}" class="block text-[11px] font-black tracking-widest text-gray-400 uppercase select-none">
            {{ $label }}
            @if($required)
                <span class="text-rose-500 ml-0.5">*</span>
            @endif
        </label>
    @endif

    <div>
        {{ $slot }}
    </div>

    @if($error)
        <p class="mt-1 text-[10px] font-black text-rose-500 uppercase tracking-widest animate-in fade-in slide-in-from-top-1 duration-200">{{ $error }}</p>
    @elseif($help)
        <p class="mt-1 text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ $help }}</p>
    @endif
</div>
