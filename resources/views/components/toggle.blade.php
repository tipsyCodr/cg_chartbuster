<div x-data="{ toggled: {{ $initialState ? 'true' : 'false' }} }" class="flex items-center">
    <div class="relative inline-block w-10 mr-2 align-middle select-none">
        <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="hidden" x-model="toggled">
        <label for="{{ $id }}" class="block overflow-hidden h-6 rounded-full cursor-pointer" 
               :class="toggled ? 'bg-green-500' : 'bg-gray-300'">
            <span class="block h-6 w-5 rounded-full bg-white transition transform" 
                  :class="toggled ? 'translate-x-4' : 'translate-x-0'"></span>
        </label>
    </div>
    @if($label)
        <label for="{{ $id }}" class="text-sm font-medium text-gray-700">{{ $label }}</label>
    @endif
</div>
