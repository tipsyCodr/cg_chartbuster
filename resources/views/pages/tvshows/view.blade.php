<x-app-layout>
    @php
        $artistModel = new App\Models\Artist();
        $trailerRaw = trim((string) ($tvshow->trailer_url ?? ''));
        $trailerRawEmbed = str_contains(strtolower($trailerRaw), '<iframe') || str_contains(strtolower($trailerRaw), '<video');
        $trailerEmbedIframeSrc = null;
        $trailerEmbedVideoSrc = null;
        $trailerIframeUrl = null;
        $trailerVideoUrl = null;
        $youtubeId = null;
        $vimeoId = null;

        if ($trailerRawEmbed) {
            if (preg_match('/<iframe[^>]+src=["\\\']([^"\\\']+)["\\\']/i', $trailerRaw, $match)) {
                $trailerEmbedIframeSrc = $match[1];
            } elseif (preg_match('/<video[^>]+src=["\\\']([^"\\\']+)["\\\']/i', $trailerRaw, $match)) {
                $trailerEmbedVideoSrc = $match[1];
            } elseif (preg_match('/<source[^>]+src=["\\\']([^"\\\']+)["\\\']/i', $trailerRaw, $match)) {
                $trailerEmbedVideoSrc = $match[1];
            }
        }

        if ($trailerRaw && !$trailerRawEmbed && filter_var($trailerRaw, FILTER_VALIDATE_URL)) {
            $host = strtolower(parse_url($trailerRaw, PHP_URL_HOST) ?? '');
            $path = parse_url($trailerRaw, PHP_URL_PATH) ?? '';
            parse_str(parse_url($trailerRaw, PHP_URL_QUERY) ?? '', $query);

            if (preg_match('/\.(mp4|webm|ogg)(\?.*)?$/i', $trailerRaw)) {
                $trailerVideoUrl = $trailerRaw;
            } elseif (str_contains($host, 'youtu.be')) {
                $youtubeId = trim($path, '/');
            } elseif (str_contains($host, 'youtube.com')) {
                if (!empty($query['v'])) {
                    $youtubeId = $query['v'];
                } elseif (str_contains($path, '/embed/') || str_contains($path, '/shorts/')) {
                    $youtubeId = basename($path);
                }
            } elseif (str_contains($host, 'vimeo.com')) {
                $vimeoId = trim($path, '/');
            }

            if ($youtubeId) {
                $trailerIframeUrl = 'https://www.youtube.com/embed/' . preg_replace('/[^a-zA-Z0-9_-]/', '', $youtubeId) . '?rel=0';
            } elseif ($vimeoId && ctype_digit($vimeoId)) {
                $trailerIframeUrl = 'https://player.vimeo.com/video/' . $vimeoId;
            } elseif (!$trailerVideoUrl) {
                $trailerIframeUrl = $trailerRaw;
            }
        }

        $tvshowGenresText = $tvshow->genres->pluck('name')->implode(', ') ?: 'N/A';
        $metaDescription = \Illuminate\Support\Str::limit(strip_tags($tvshow->description), 160);
        $metaImage = $tvshow->poster_image ? asset("storage/{$tvshow->poster_image}") : asset('images/logo.png');
    @endphp

    @section('meta_title', $tvshow->title . ' - CG Chartbusters')
    @section('meta_description', $metaDescription)
    @section('meta_image', $metaImage)
    @section('og_type', 'video.tv_show')

    <div class="container mx-auto max-w-7xl px-3 py-6 sm:px-4">
        <div class="grid gap-6 lg:grid-cols-12">
            
            <!-- Row 1 Left: Video Player -->
            <section class="order-1 lg:col-span-7">
                <div class="hero-media w-full overflow-hidden rounded-xl bg-black shadow-2xl aspect-video border border-gray-700/30">
                    @if($trailerEmbedIframeSrc)
                        <iframe src="{{ $trailerEmbedIframeSrc }}" title="{{ $tvshow->title }} trailer" class="w-full h-full" loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    @elseif($trailerEmbedVideoSrc)
                        <video src="{{ $trailerEmbedVideoSrc }}" class="w-full h-full" controls playsinline preload="metadata"></video>
                    @elseif($trailerIframeUrl)
                        <iframe src="{{ $trailerIframeUrl }}" title="{{ $tvshow->title }} trailer" class="w-full h-full" loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    @elseif($trailerVideoUrl)
                        <video src="{{ $trailerVideoUrl }}" class="w-full h-full" controls playsinline preload="metadata"></video>
                    @elseif($tvshow->poster_image_landscape)
                        <img src="{{ asset("storage/{$tvshow->poster_image_landscape}") }}" alt="{{ $tvshow->title }}"
                            class="w-full h-full object-cover rounded-xl">
                    @elseif($tvshow->poster_image)
                        <img src="{{ asset("storage/{$tvshow->poster_image}") }}" alt="{{ $tvshow->title }}"
                            class="w-full h-full object-cover rounded-xl">
                    @else
                        <div class="flex h-full min-h-64 w-full items-center justify-center text-center text-sm text-gray-400">
                            Trailer not available
                        </div>
                    @endif
                </div>
            </section>

            <!-- Row 1 Right: Details Card -->
            <section class="order-2 lg:col-span-5 bg-gray-800/40 backdrop-blur-md rounded-xl p-4 sm:p-5 border border-gray-700/50 flex flex-col justify-between shadow-xl">
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="h-36 w-24 sm:h-44 sm:w-30 shrink-0 overflow-hidden rounded-lg bg-gray-950 border border-gray-700 shadow-lg">
                            @if($tvshow->poster_image)
                                <img src="{{ asset("storage/{$tvshow->poster_image}") }}" alt="{{ $tvshow->title }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-xs text-gray-500">Poster</div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h1 class="break-words text-xl sm:text-2xl font-black text-white leading-tight">{{ $tvshow->title }}</h1>
                            <div class="mt-2 inline-flex items-center gap-1 text-xs text-yellow-500 font-bold bg-gray-900/60 px-2.5 py-1 rounded-full border border-gray-700/30">
                                <i class="fa-solid fa-star"></i>
                                <span>{{ $tvshow->cg_chartbusters_ratings ?? 0 }}/10</span>
                                <span class="text-gray-400 font-medium">({{ $reviews->total() }} Votes)</span>
                            </div>
                            <div class="mt-3 space-y-1 text-xs sm:text-sm text-gray-300">
                                <p><span class="text-gray-400 font-medium">Released:</span> {{ $tvshow->release_date ? \Carbon\Carbon::parse($tvshow->release_date)->format($tvshow->is_release_year_only ? 'Y' : 'd M Y') : 'N/A' }}</p>
                                <p><span class="text-gray-400 font-medium">Genres:</span> {{ $tvshowGenresText }}</p>
                                <p><span class="text-gray-400 font-medium">Language:</span> {{ $tvshow->region?->name ?? 'N/A' }}</p>
                                <p><span class="text-gray-400 font-medium">CBFC:</span> {{ $tvshow->cbfc ?: 'NA' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-2">
                        <button onclick="document.getElementById('review-section').scrollIntoView({behavior:'smooth'})"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-yellow-500 px-5 py-2.5 font-black text-black transition-all hover:bg-yellow-600 active:scale-95 shadow-lg">
                            <i class="fa-solid fa-star"></i>
                            Rate This TV Show
                        </button>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-700/30">
                    <x-social-share :url="url()->current()" :title="$tvshow->title" />
                </div>
            </section>

            <!-- Row 2: Plot (Full Width!) -->
            <section class="order-3 lg:col-span-12 rounded-xl border border-gray-700/50 bg-gray-800/40 p-4 sm:p-6 shadow-xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-4 pb-3 border-b border-gray-700/30">
                    <h3 class="text-lg font-black text-white flex items-center gap-2">
                        <span class="w-1 h-5 bg-yellow-500 rounded"></span> {{ $tvshow->title }} Plot
                    </h3>
                    <x-language-switcher variant="compact" />
                </div>
                <div class="max-h-[20rem] overflow-y-auto whitespace-pre-line text-sm leading-relaxed text-gray-300 pr-2">
                    @if(app()->getLocale() == 'chh' && !empty($tvshow->content_description_chh))
                        {{ $tvshow->content_description_chh }}
                    @elseif(app()->getLocale() == 'hi' && !empty($tvshow->content_description))
                        {{ $tvshow->content_description }}
                    @else
                        {{ $tvshow->description }}
                    @endif
                </div>
            </section>

            <!-- Row 3 Left: Cast Grid -->
            <section class="order-4 lg:col-span-7">
                <h2 class="mb-4 flex items-center text-lg font-black text-white sm:text-xl md:text-2xl gap-2">
                    <span class="w-1.5 h-6 bg-yellow-500 rounded"></span>Cast
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @forelse ($tvshow->artists as $artist)
                        @php
                            $rolesText = implode(', ', $artist->pivot->category_names);
                        @endphp
                        <div class="cast-member rounded-xl bg-gray-800/50 border border-gray-700/40 p-3 hover:bg-gray-700 hover:border-yellow-500/30 transition-all duration-300 shadow-md">
                            <a href="{{ route('artist.show', $artist->slug) }}" class="flex items-center gap-3">
                                <img src="{{ asset('storage/' . $artist->photo) }}" alt="{{ $artist->name }}"
                                    class="h-12 w-12 rounded-full border-2 border-gray-600 object-cover shrink-0">
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-white truncate break-words">{{ $artist->name }}</h4>
                                    <p class="text-[10px] text-gray-400 truncate break-words mt-0.5">{{ $rolesText }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="col-span-full text-gray-500 italic bg-gray-800/20 rounded-xl p-4 text-center text-sm border border-gray-700/30">No cast members listed.</p>
                    @endforelse
                </div>
            </section>

            <!-- Row 3 Right: Reviews Section -->
            <section id="review-section" class="order-5 lg:col-span-5 space-y-6">
                <div>
                    <h2 class="mb-4 flex items-center text-lg font-black text-white sm:text-xl md:text-2xl gap-2">
                        <span class="w-1.5 h-6 bg-yellow-500 rounded"></span>Reviews
                    </h2>

                    <div class="mb-6 rounded-xl bg-gray-800/60 border border-gray-700/50 p-4 sm:p-6 shadow-xl">
                        <h3 class="mb-4 text-base font-bold text-white sm:text-lg">Post a Review</h3>
                        <form action="{{ route('tv-shows.reviews.store', $tvshow) }}" method="POST">
                            @csrf
                            <input type="hidden" name="tvshow_id" value="{{ $tvshow->id }}">

                            <div class="mb-4">
                                <x-input-label for="review_text" :value="__('Review')" class="text-gray-300 text-sm font-semibold" />
                                <x-textarea id="review_text"
                                    class="mt-2 block w-full rounded-lg border-gray-600 bg-gray-750 text-white focus:ring-yellow-500 focus:border-yellow-500"
                                    name="review_text" rows="4" placeholder="Write your review..."
                                    required>{{ old('review_text') }}</x-textarea>
                                <x-input-error :messages="$errors->get('review_text')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label for="rating" :value="__('Rating')" class="text-gray-300 text-sm font-semibold" />
                                <x-star-rating id="rating" class="mt-2 block w-full" name="rating" required></x-star-rating>
                                <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                            </div>

                            <x-input-submit
                                class="w-full rounded-lg bg-yellow-500 px-6 py-2.5 font-bold text-black transition-colors hover:bg-yellow-600">
                                Submit Review
                            </x-input-submit>
                        </form>
                    </div>

                    <div class="space-y-4 text-gray-200">
                        @forelse($reviews as $review)
                            <div class="review-item rounded-xl border border-gray-700 bg-gray-855/40 p-4 shadow-md">
                                <div class="mb-3 flex flex-wrap items-start justify-between gap-2">
                                    <div class="flex min-w-0 items-center">
                                        <i class="fa-solid fa-user-circle mr-3 shrink-0 text-2xl text-yellow-400"></i>
                                        <div class="min-w-0">
                                            <strong class="break-words text-yellow-300 text-sm">
                                                {!! $review->user ? $review->user->name : '<span class="text-gray-500">[deleted account]</span>' !!}
                                            </strong>
                                            <div class="mt-1 flex flex-wrap items-center gap-x-1 gap-y-1">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <i class="fa fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }} text-[10px]"></i>
                                                @endfor
                                                <span class="ml-1 text-[10px] text-gray-400 font-bold">{{ $review->rating }}/10</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-gray-500 sm:ml-auto">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                                <p class="break-words text-gray-300 text-sm">{{ $review->review_text }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic bg-gray-850/50 rounded-xl p-4 text-center text-sm border border-gray-800/30">No reviews yet. Be the first to review!</p>
                        @endforelse
                    </div>

                    @if($reviews->hasPages())
                        <div class="paginate mt-6 overflow-x-auto">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
