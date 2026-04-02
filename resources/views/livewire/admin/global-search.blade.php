<div class="relative w-48 lg:w-64" x-data="{ open: @entangle('showResults') }" @click.away="open = false">
    <div class="relative flex items-center">
        <span class="absolute left-4 text-gray-400 z-10">
            <i class="fas fa-search"></i>
        </span>
        <input 
            type="text" 
            wire:model.live.debounce.300ms="query"
            @focus="if($wire.query.length >= 2) open = true"
            placeholder="Global search..." 
            class="bg-gray-100 border-none rounded-2xl pl-10 pr-10 py-2.5 text-sm focus:ring-2 focus:ring-blue-500/20 w-full transition-all outline-none placeholder:text-gray-400 font-medium"
        >
        @if(strlen($query) > 0)
            <button wire:click="clearSearch" class="absolute right-3 text-gray-400 hover:text-rose-500 transition-colors z-10">
                <i class="fas fa-times-circle"></i>
            </button>
        @endif
    </div>

    @if($showResults)
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        x-cloak 
        class="absolute left-0 mt-3 w-[400px] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform origin-top-left z-[100]"
    >
        <div class="max-h-[480px] overflow-y-auto custom-scrollbar">
            @foreach($results as $category => $items)
                <div class="px-4 py-2 bg-gray-50/50 border-b border-gray-50">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $category }}</span>
                </div>
                @foreach($items as $item)
                    <a href="{{ $item['url'] }}" class="flex items-center px-4 py-3.5 hover:bg-blue-50 transition-all group border-b border-gray-50 last:border-0">
                        <div class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center mr-3 group-hover:bg-white group-hover:text-blue-600 group-hover:shadow-sm transition-all border border-gray-100">
                            <i class="{{ $item['icon'] }} text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $item['title'] }}</p>
                            @if(isset($item['subtitle']))
                                <p class="text-[10px] text-gray-400 leading-tight">{{ $item['subtitle'] }}</p>
                            @else
                                <p class="text-[10px] text-gray-400 opacity-60 uppercase font-black tracking-tighter">{{ $item['type'] }}</p>
                            @endif
                        </div>
                        <div class="ml-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-arrow-right text-[10px] text-blue-500"></i>
                        </div>
                    </a>
                @endforeach
            @endforeach
        </div>

        <div class="p-3 border-t border-gray-50 bg-gray-50/30 text-center">
            <p class="text-[10px] text-gray-400 font-bold tracking-tight">
                Showing top results for <span class="text-blue-600">"{{ $query }}"</span>
            </p>
        </div>
    </div>
    @endif
</div>
