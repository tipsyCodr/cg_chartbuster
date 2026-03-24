<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900/50 backdrop-blur-md overflow-hidden shadow-2xl rounded-2xl border border-white/5">
                <div class="p-8 md:p-12">
                    <h1 class="text-4xl font-black mb-8 text-yellow-500 uppercase tracking-tighter">Disclaimer</h1>
                    <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed">
                        <p class="mb-6 text-gray-400 font-medium italic">Last updated: {{ date('F d, Y') }}</p>
                        
                        <section class="mb-8">
                            <h2 class="text-xl font-bold text-white mb-4">1. Information Accuracy</h2>
                            <p>The information provided by CG Chartbusters is for general informational purposes only. All information on the site is provided in good faith, however we make no representation or warranty of any kind, express or implied, regarding the accuracy, adequacy, validity, reliability, availability, or completeness of any information on the site.</p>
                        </section>

                        <section class="mb-8">
                            <h2 class="text-xl font-bold text-white mb-4">2. External Links</h2>
                            <p>The site may contain links to other websites or content belonging to or originating from third parties. Such external links are not investigated, monitored, or checked for accuracy, adequacy, validity, reliability, availability, or completeness by us.</p>
                        </section>

                        <section class="mb-8">
                            <h2 class="text-xl font-bold text-white mb-4">3. Professional Disclaimer</h2>
                            <p>The site cannot and does not contain legal or professional advice. The information is provided for general informational and educational purposes only and is not a substitute for professional advice. Accordingly, before taking any actions based upon such information, we encourage you to consult with the appropriate professionals.</p>
                        </section>

                        <div class="mt-12 p-6 bg-yellow-500/10 border border-yellow-500/20 rounded-xl">
                            <p class="text-sm text-yellow-500 font-bold">Note: This is a placeholder page. Full legal content will be updated by the administrator soon.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
