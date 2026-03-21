@props(['options' => [], 'selected' => [], 'name' => '', 'placeholder' => 'Select Options'])

<div x-data="{
    open: false,
    search: '',
    options: {{ json_encode($options->map(fn($o) => ['id' => $o->id, 'name' => $o->name])->toArray()) }},
    selected: {{ json_encode($selected) }},
    toggle(id) {
        if (this.selected.includes(id)) {
            this.selected = this.selected.filter(i => i != id);
        } else {
            this.selected.push(id);
        }
    },
    get filteredOptions() {
        if (!this.search) return this.options;
        return this.options.filter(opt => opt.name.toLowerCase().includes(this.search.toLowerCase()));
    },
    get selectedNames() {
        let names = this.options.filter(opt => this.selected.includes(opt.id)).map(opt => opt.name);
        return names.length > 0 ? names.join(', ') : '{{ $placeholder }}';
    }
}" class="relative w-full" @click.away="open = false">
    <div @click="open = !open" 
         class="w-full p-2 border border-gray-300 rounded cursor-pointer flex justify-between items-center bg-white min-h-[42px] hover:border-gray-400 transition-colors">
        <div class="flex flex-wrap gap-1 max-w-[90%] pointer-events-none overflow-hidden">
            <template x-if="selected.length === 0">
                <span class="text-sm text-gray-400">{{ $placeholder }}</span>
            </template>
            <template x-for="id in selected" :key="id">
                <span class="bg-accent/10 border border-accent/20 text-accent px-2 py-0.5 rounded text-xs flex items-center gap-1">
                    <span x-text="options.find(o => o.id == id)?.name"></span>
                </span>
            </template>
        </div>
        <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>

    <!-- Hidden Inputs for form submission -->
    <template x-for="id in selected" :key="'input-'+id">
        <input type="hidden" :name="'{{ $name }}[]'" :value="id">
    </template>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         class="absolute z-[100] w-full mt-1 bg-white border border-gray-300 rounded shadow-xl max-h-60 flex flex-col pt-1 overflow-hidden">
        <div class="px-2 py-2 border-b border-gray-100 bg-gray-50">
            <input type="text" x-model="search" placeholder="Search..." 
                   @keydown.enter.prevent="if(filteredOptions.length > 0) toggle(filteredOptions[0].id)"
                   class="w-full p-1.5 text-sm border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-1 focus:ring-accent focus:border-accent">
        </div>
        <div class="overflow-y-auto flex-1 custom-scrollbar">
            <template x-for="option in filteredOptions" :key="option.id">
                <div @click="toggle(option.id)" 
                     class="px-3 py-2.5 text-sm cursor-pointer hover:bg-gray-100 flex items-center justify-between transition-colors"
                     :class="{'bg-accent/5 font-semibold text-accent': selected.includes(option.id)}">
                    <span x-text="option.name"></span>
                    <span x-show="selected.includes(option.id)" class="text-accent">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                </div>
            </template>
            <div x-show="filteredOptions.length === 0" class="px-3 py-4 text-center text-sm text-gray-500 italic">No results found</div>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>
