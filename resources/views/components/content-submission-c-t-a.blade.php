<div class="fixed bottom-6 right-6 z-50 group">
    <!-- Tooltip -->
    <div class="absolute bottom-full right-0 mb-3 px-3 py-1 bg-yellow-500 text-black text-xs font-bold rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
        Creators can submit their content here
        <div class="absolute top-full right-4 border-8 border-transparent border-t-yellow-500"></div>
    </div>

    <!-- FAB Button -->
    <a href="{{ route('content.submit') }}" 
       class="flex items-center justify-center w-14 h-14 md:w-auto md:px-6 md:h-12 bg-yellow-500 hover:bg-yellow-400 text-black rounded-full shadow-2xl transition-all duration-300 hover:scale-110 active:scale-95 group">
        <i class="fas fa-plus text-xl md:mr-2"></i>
        <span class="hidden md:inline font-bold uppercase tracking-wider text-sm">Add Your Content</span>
    </a>
</div>