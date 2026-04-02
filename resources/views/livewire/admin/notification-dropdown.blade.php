<div class="relative" x-data="{ open: false }" wire:poll.300s>
    <button @click="open = !open" @click.away="open = false" 
            class="p-3 text-gray-500 hover:bg-gray-100 rounded-2xl relative transition-all">
        <i class="far fa-bell text-xl"></i>
        @if($unreadCount > 0)
            <span class="absolute top-3 right-3 w-2 h-2 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
        @endif
    </button>
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         x-cloak 
         class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform origin-top-right z-50">
        
        <div class="p-4 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
            <span class="font-bold text-sm text-gray-800">Notifications</span>
            @if($unreadCount > 0)
                <span class="text-[10px] bg-rose-50 text-rose-600 px-2 py-0.5 rounded-full font-black tracking-wider uppercase border border-rose-100">{{ $unreadCount }} ACTION REQUIRED</span>
            @endif
        </div>

        <div class="py-2 max-h-[400px] overflow-y-auto">
            @forelse($notifications as $notification)
                <a href="{{ $notification['link'] }}" class="flex px-4 py-3 hover:bg-gray-50 transition-all border-b border-gray-50 last:border-0 group">
                    <div @class([
                        'w-10 h-10 rounded-xl flex items-center justify-center mr-3 shrink-0 shadow-sm transition-transform group-hover:scale-110',
                        'bg-blue-50 text-blue-600 border border-blue-100' => $notification['color'] === 'blue',
                        'bg-amber-50 text-amber-600 border border-amber-100' => $notification['color'] === 'amber',
                        'bg-rose-50 text-rose-600 border border-rose-100' => $notification['color'] === 'rose',
                    ])>
                        <i class="{{ $notification['icon'] }} text-xs"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <p class="text-xs font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ $notification['title'] }}</p>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-0.5 line-clamp-2 leading-relaxed">{{ $notification['description'] }}</p>
                        <p class="text-[9px] text-gray-400 mt-1.5 uppercase font-black tracking-widest flex items-center">
                            <i class="far fa-clock mr-1 opacity-50"></i>
                            {{ $notification['time']->diffForHumans() }}
                        </p>
                    </div>
                </a>
            @empty
                <div class="px-4 py-12 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                        <i class="far fa-bell-slash text-gray-300 text-2xl"></i>
                    </div>
                    <p class="text-xs font-bold text-gray-500">All caught up!</p>
                    <p class="text-[10px] text-gray-400 mt-1">No new notifications at this time.</p>
                </div>
            @endforelse
        </div>

        <div class="p-2 border-t border-gray-50 bg-gray-50/30">
            <a href="#" class="block py-2.5 text-center text-[10px] font-black text-gray-500 hover:text-blue-600 hover:bg-white hover:shadow-sm rounded-xl transition-all uppercase tracking-widest">
                VIEW ALL NOTIFICATIONS
            </a>
        </div>
    </div>
</div>
