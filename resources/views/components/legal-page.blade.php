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



                <div class="legal-content">
                    {{ $slot }}
                </div>

                <style>
                    .legal-content h2 {
                        font-size: 1.5rem;
                        font-weight: 900;
                        letter-spacing: -0.025em;
                        color: #fbbf24;
                        margin-top: 3.5rem;
                        margin-bottom: 1.5rem;
                        text-transform: uppercase;
                        border-left: 4px solid #fbbf24;
                        padding-left: 1rem;
                    }
                    .legal-content h3 {
                        font-size: 1.125rem;
                        font-weight: 800;
                        color: #ffffff;
                        margin-top: 2.5rem;
                        margin-bottom: 1rem;
                    }
                    .legal-content p {
                        color: #d1d5db;
                        line-height: 1.625;
                        font-size: 1rem;
                        margin-bottom: 1.5rem;
                    }
                    .legal-content ul {
                        list-style-type: disc;
                        padding-left: 1.5rem;
                        margin-bottom: 1.5rem;
                        color: #d1d5db;
                    }
                    .legal-content li {
                        margin-bottom: 0.75rem;
                    }
                    .legal-content strong {
                        color: #ffffff;
                        font-weight: 900;
                    }
                    .legal-content a {
                        color: #fbbf24;
                        font-weight: 700;
                        text-decoration: underline;
                    }
                    .legal-content table {
                        width: 100%;
                        margin-bottom: 2rem;
                        border-collapse: collapse;
                        background: rgba(255, 255, 255, 0.02);
                        border-radius: 1rem;
                        overflow: hidden;
                    }
                    .legal-content th {
                        background: rgba(251, 191, 36, 0.1);
                        color: #fbbf24;
                        text-align: left;
                        padding: 1rem;
                        font-size: 0.875rem;
                        font-weight: 900;
                        text-transform: uppercase;
                        letter-spacing: 0.05em;
                    }
                    .legal-content td {
                        padding: 1rem;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                        color: #d1d5db;
                        font-size: 0.875rem;
                    }
                    .legal-content .warning, .legal-content .warning-box,
                    .legal-content .danger, .legal-content .danger-box,
                    .legal-content .success, .legal-content .success-box,
                    .legal-content .info, .legal-content .info-box {
                        padding: 1.5rem;
                        border-radius: 1rem;
                        margin-bottom: 2rem;
                        border: 1px solid transparent;
                    }
                    .legal-content .warning, .legal-content .warning-box {
                        background: rgba(251, 191, 36, 0.05);
                        border-color: rgba(251, 191, 36, 0.2);
                        color: #fbbf24;
                    }
                    .legal-content .danger, .legal-content .danger-box {
                        background: rgba(239, 68, 68, 0.05);
                        border-color: rgba(239, 68, 68, 0.2);
                        color: #f87171;
                    }
                    .legal-content .success, .legal-content .success-box {
                        background: rgba(34, 197, 94, 0.05);
                        border-color: rgba(34, 197, 94, 0.2);
                        color: #4ade80;
                    }
                    .legal-content .info, .legal-content .info-box {
                        background: rgba(59, 130, 246, 0.05);
                        border-color: rgba(59, 130, 246, 0.2);
                        color: #60a5fa;
                    }
                    .legal-content .footer {
                        margin-top: 4rem;
                        padding-top: 2rem;
                        border-top: 1px solid rgba(255, 255, 255, 0.1);
                        font-size: 0.75rem;
                        color: #9ca3af;
                        text-align: center;
                    }
                </style>
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
