@props(['name', 'value' => null])

<div x-data="{ rating: {{ $value ?? 0 }}, hover: 0 }" class="flex space-x-1">
    <input type="hidden" name="{{ $name }}" x-model="rating" value="{{ $value ?? 0 }}">
    
    @for ($i = 1; $i <= 10; $i++)
        <button 
            type="button" 
            class="text-gray-400 hover:text-yellow-400 focus:outline-none"
            :class="{ 'text-yellow-400': rating >= {{ $i }} || hover >= {{ $i }} }"
            @mouseover="hover = {{ $i }}"
            @mouseleave="hover = 0"
            @click="rating = {{ $i }}"
            @click.away="hover = 0"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-8 h-8" viewBox="0 0 24 24">
                <path d="M12 .587l3.668 7.429 8.2 1.192-5.934 5.786 1.4 8.171-7.334-3.857-7.333 3.857 1.399-8.171-5.933-5.786 8.2-1.192z"/>
            </svg>
        </button>
    @endfor
</div>