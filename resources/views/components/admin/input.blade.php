@props([
    'disabled' => false,
    'error' => false,
    'type' => 'text',
])

<input {{ $disabled ? 'disabled' : '' }} 
    {{ $attributes->merge([
        'type' => $type,
        'class' => 'w-full px-4 py-3 bg-white border rounded-xl text-sm font-bold text-gray-700 outline-none transition-all duration-200' . 
        ($error 
            ? ' border-rose-500 ring-4 ring-rose-500/10 focus:border-rose-600 focus:ring-rose-600/15' 
            : ' border-gray-100 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 hover:border-gray-200'
        ) . 
        ($disabled ? ' bg-gray-50/50 cursor-not-allowed opacity-60' : '')
    ]) }}
>
