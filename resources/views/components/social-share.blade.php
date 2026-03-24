@props(['url', 'title', 'image' => null, 'showInstagram' => true])

<div class="w-full basis-full flex flex-col gap-3 mt-8 p-6 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-sm">
    <div class="flex items-center justify-between">
        <span class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Share this page</span>
        <div class="h-px flex-1 bg-gradient-to-r from-white/10 to-transparent ml-4"></div>
    </div>
    
    <div class="flex flex-wrap items-center gap-3">
        {{-- WhatsApp --}}
        <a href="https://api.whatsapp.com/send?text={{ urlencode($title . ' ' . $url) }}" 
           target="_blank" 
           class="group flex items-center gap-2 px-4 py-2 bg-[#25D366]/10 hover:bg-[#25D366] text-[#25D366] hover:text-white border border-[#25D366]/20 rounded-xl transition-all duration-300 shadow-lg"
           title="Share on WhatsApp">
            <i class="fab fa-whatsapp text-lg"></i>
            <span class="text-xs font-bold uppercase tracking-wider">WhatsApp</span>
        </a>

        {{-- Facebook --}}
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" 
           target="_blank" 
           class="group flex items-center gap-2 px-4 py-2 bg-[#1877F2]/10 hover:bg-[#1877F2] text-[#1877F2] hover:text-white border border-[#1877F2]/20 rounded-xl transition-all duration-300 shadow-lg"
           title="Share on Facebook">
            <i class="fab fa-facebook-f text-lg"></i>
            <span class="text-xs font-bold uppercase tracking-wider">Facebook</span>
        </a>

        {{-- X (Twitter) --}}
        <a href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}&text={{ urlencode($title) }}" 
           target="_blank" 
           class="group flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white text-white hover:text-black border border-white/20 rounded-xl transition-all duration-300 shadow-lg"
           title="Share on X">
            <i class="fab fa-x-twitter text-lg"></i>
            <span class="text-xs font-bold uppercase tracking-wider">Twitter</span>
        </a>

        @if($showInstagram)
            {{-- Instagram (Link Copy) --}}
            <button onclick="copyToClipboard('{{ $url }}', 'Instagram link copied!')" 
                    class="group flex items-center gap-2 px-4 py-2 bg-gradient-to-tr from-[#f9ce34]/10 via-[#ee2a7b]/10 to-[#6228d7]/10 hover:from-[#f9ce34] hover:via-[#ee2a7b] hover:to-[#6228d7] text-[#ee2a7b] hover:text-white border border-[#ee2a7b]/20 rounded-xl transition-all duration-300 shadow-lg"
                    title="Copy for Instagram">
                <i class="fab fa-instagram text-lg"></i>
                <span class="text-xs font-bold uppercase tracking-wider">Instagram</span>
            </button>
        @endif

        {{-- Copy Link --}}
        <button onclick="copyToClipboard('{{ $url }}', 'Link copied to clipboard!')" 
                class="group flex items-center gap-2 px-4 py-2 bg-gray-500/10 hover:bg-gray-500 text-gray-400 hover:text-white border border-white/10 rounded-xl transition-all duration-300 shadow-lg"
                title="Copy Link">
            <i class="fas fa-link text-lg"></i>
            <span class="text-xs font-bold uppercase tracking-wider">Copy Link</span>
        </button>
    </div>
</div>

<script>
if (typeof copyToClipboard === 'undefined') {
    window.copyToClipboard = function(text, message) {
        navigator.clipboard.writeText(text).then(() => {
            if (window.showToast) {
                window.showToast(message, 'success');
            } else {
                alert(message);
            }
        });
    }
}
</script>
