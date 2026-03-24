<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900/50 backdrop-blur-md overflow-hidden shadow-2xl rounded-2xl border border-white/5">
                <div class="p-8 md:p-12">
                    <h1 class="text-4xl font-black mb-8 text-yellow-500 uppercase tracking-tighter">Content Moderation Policy</h1>
                    <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed">
                        <p class="mb-6 text-gray-400 font-medium italic">Last updated: {{ date('F d, Y') }}</p>
                        
                        <section class="mb-8">
                            <h2 class="text-xl font-bold text-white mb-4">1. Our Commitment</h2>
                            <p>We are dedicated to maintaining a safe and high-quality environment for all our users. This policy outlines our approach to content moderation and the standards we apply to user-submitted content.</p>
                        </section>

                        <section class="mb-8">
                            <h2 class="text-xl font-bold text-white mb-4">2. Moderation Process</h2>
                            <p>We use a combination of automated tools and human review to monitor and moderate content on CG Chartbusters. We reserve the right to remove any content that violates our community guidelines or terms of service.</p>
                        </section>

                        <section class="mb-8">
                            <h2 class="text-xl font-bold text-white mb-4">3. Appeals</h2>
                            <p>If your content has been removed and you believe it was done in error, you may appeal the decision by contacting our moderation team with the relevant details.</p>
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
