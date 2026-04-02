@props(['title', 'lastUpdated' => null])

<x-app-layout>
    @section('meta_title', $title . ' | ' . config('app.name'))

    <div class="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-black to-gray-950 min-h-screen">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-16 px-4">
                @if($lastUpdated)
                    <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-yellow-400/10 border border-yellow-400/20 mb-6">
                        <span class="text-[10px] font-black text-yellow-400 uppercase tracking-widest">Last Updated: {{ $lastUpdated }}</span>
                    </div>
                @endif
                <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight leading-tight">
                    {{ $title }}
                </h1>
                <div class="mt-8 w-24 h-1.5 bg-gradient-to-r from-yellow-400 to-yellow-600 mx-auto rounded-full shadow-lg shadow-yellow-400/20"></div>
            </div>

            <!-- Content Area -->
            <div class="bg-gray-900/40 backdrop-blur-2xl border border-white/5 rounded-[48px] p-8 md:p-20 shadow-2xl relative overflow-hidden group">
                <!-- Background Decorative Elements -->
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-yellow-400/5 rounded-full blur-[100px]"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-yellow-400/5 rounded-full blur-[100px]"></div>

                <div class="prose prose-invert prose-yellow max-w-none 
                            prose-h1:text-white prose-h1:font-black prose-h1:tracking-tight
                            prose-h2:text-2xl prose-h2:font-black prose-h2:tracking-tight prose-h2:text-yellow-400 prose-h2:mt-12 prose-h2:mb-6
                            prose-p:text-gray-400 prose-p:leading-relaxed prose-p:text-base prose-p:mb-6
                            prose-ul:text-gray-400 prose-li:my-3 prose-strong:text-white prose-strong:font-black">
                    {{ $slot }}
                </div>
            </div>

            <!-- Contact/Support Note -->
            <div class="mt-12 flex flex-col md:flex-row items-center justify-between p-8 bg-white/[0.02] rounded-[32px] border border-white/[0.05] backdrop-blur-sm">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Administrative Support</p>
                    <p class="text-sm text-gray-300">Questions about our policies? Reach out to our legal team.</p>
                </div>
                <a href="mailto:cgchartbusters@gmail.com" 
                   class="flex items-center px-6 py-3 bg-white text-black text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-yellow-400 transition-all duration-300 shadow-xl shadow-white/5">
                    <i class="fas fa-envelope mr-3"></i>
                    Email Us
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
