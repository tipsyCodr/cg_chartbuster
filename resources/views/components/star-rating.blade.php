@props(['name', 'value' => null])

<div x-data="{ rating: {{ $value ?? 0 }}, hover: 0 }" {{ $attributes->merge(['class' => 'flex flex-wrap gap-0.5 sm:gap-1']) }}>
    <input type="hidden" name="{{ $name }}" x-model="rating" value="{{ $value ?? 0 }}">
    
    @for ($i = 1; $i <= 10; $i++)
        <button 
            type="button" 
            aria-label="Rate {{ $i }} out of 10"
            class="inline-flex min-h-8 min-w-8 items-center justify-center rounded p-1 text-gray-400 hover:text-yellow-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-400/70 sm:min-h-9 sm:min-w-9"
            :class="{ 'text-yellow-400': rating >= {{ $i }} || hover >= {{ $i }} }"
            @mouseover="hover = {{ $i }}"
            @mouseleave="hover = 0"
            @click="rating = {{ $i }}"
            @click.away="hover = 0"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 24 24">
                <path d="M12 .587l3.668 7.429 8.2 1.192-5.934 5.786 1.4 8.171-7.334-3.857-7.333 3.857 1.399-8.171-5.933-5.786 8.2-1.192z"/>
            </svg>
        </button>
    @endfor
</div>
