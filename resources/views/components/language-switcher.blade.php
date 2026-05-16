@props(['variant' => 'default'])

@if($variant === 'compact')
    <div class="flex items-center gap-3">
        <p class="hidden sm:block text-[9px] font-black text-gray-500 uppercase tracking-widest leading-tight">
            Official <br> Translation:
        </p>

        <div class="flex items-center bg-black/40 rounded-xl p-1 border border-white/5 backdrop-blur-sm">
            <a href="{{ route('set-locale', 'en') }}" 
               class="px-3 py-1.5 text-[10px] font-black rounded-lg transition-all {{ app()->getLocale() == 'en' ? 'bg-yellow-500 text-black shadow-lg' : 'text-gray-400 hover:text-white' }}">
                ENG
            </a>
            <a href="{{ route('set-locale', 'hi') }}" 
               class="px-3 py-1.5 text-[10px] font-black rounded-lg transition-all {{ app()->getLocale() == 'hi' ? 'bg-yellow-500 text-black shadow-lg' : 'text-gray-400 hover:text-white' }}">
                हिन्दी
            </a>
            <a href="{{ route('set-locale', 'chh') }}" 
               class="group relative px-3 py-1.5 text-[10px] font-black rounded-lg transition-all {{ app()->getLocale() == 'chh' ? 'bg-yellow-500 text-black shadow-lg' : 'text-gray-400 hover:text-white' }}">
                CG
                <span class="absolute -top-10 left-1/2 -translate-x-1/2 px-2 py-1 bg-yellow-500 text-black text-[9px] font-black rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none shadow-2xl z-50">
                    Curated Chhattisgarhi Feature
                </span>
            </a>
        </div>
    </div>
@else
    <div class="flex flex-col sm:flex-row items-center gap-3 bg-gray-900/50 backdrop-blur-md border border-white/5 rounded-2xl p-3 mb-8">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-yellow-400/10 flex items-center justify-center">
                <i class="fas fa-language text-yellow-400"></i>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-tight">
                View this content in:
                <span class="block text-[8px] text-gray-500 font-bold">(Official Translation)</span>
            </p>
        </div>

        <div class="flex items-center bg-gray-800/80 rounded-xl p-1 border border-gray-700">
            <a href="{{ route('set-locale', 'en') }}" 
               class="px-4 py-1.5 text-xs font-black rounded-lg transition-all {{ app()->getLocale() == 'en' ? 'bg-yellow-500 text-black shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
                ENG
            </a>
            <a href="{{ route('set-locale', 'hi') }}" 
               class="px-4 py-1.5 text-xs font-black rounded-lg transition-all {{ app()->getLocale() == 'hi' ? 'bg-yellow-500 text-black shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
                हिन्दी
            </a>
            <a href="{{ route('set-locale', 'chh') }}" 
               class="group relative px-4 py-1.5 text-xs font-black rounded-lg transition-all {{ app()->getLocale() == 'chh' ? 'bg-yellow-500 text-black shadow-lg' : 'text-gray-400 hover:text-white hover:bg-gray-700' }}">
                CG
                <span class="absolute -top-8 left-1/2 -translate-x-1/2 px-2 py-1 bg-yellow-500 text-black text-[8px] font-black rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                    Special Feature: Chhattisgarhi
                </span>
            </a>
        </div>

        <div class="hidden sm:block h-8 w-px bg-white/5 mx-2"></div>

        <div class="flex items-center gap-2 opacity-60">
            <i class="fas fa-info-circle text-[10px] text-gray-500"></i>
            <p class="text-[9px] text-gray-500 font-bold leading-tight">
                Our specialized CG translation is hand-curated for the best regional experience.
            </p>
        </div>
    </div>
@endif
