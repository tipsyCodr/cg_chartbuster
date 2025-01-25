<div>
    <button type="submit" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 '.$class]) }} >
        {{ $slot ?? 'Submit' }}
    </button>
</div>