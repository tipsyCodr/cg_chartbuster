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
            <section class="order-1 lg:order-1 lg:col-span-6">
                <div class="hero-media w-full overflow-hidden rounded-lg bg-black">
                    @if($trailerEmbedIframeSrc)
                        <iframe src="{{ $trailerEmbedIframeSrc }}" title="{{ $tvshow->title }} trailer" loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    @elseif($trailerEmbedVideoSrc)
                        <video src="{{ $trailerEmbedVideoSrc }}" controls playsinline preload="metadata"></video>
                    @elseif($trailerIframeUrl)
                        <iframe src="{{ $trailerIframeUrl }}" title="{{ $tvshow->title }} trailer" loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    @elseif($trailerVideoUrl)
                        <video src="{{ $trailerVideoUrl }}" controls playsinline preload="metadata"></video>
                    @elseif($tvshow->poster_image_landscape)
                        <img src="{{ asset("storage/{$tvshow->poster_image_landscape}") }}" alt="{{ $tvshow->title }}"
                            class="w-full h-full object-cover rounded-lg">
                    @elseif($tvshow->poster_image)
                        <img src="{{ asset("storage/{$tvshow->poster_image}") }}" alt="{{ $tvshow->title }}"
                            class="w-full h-full object-cover rounded-lg">
                    @else
                        <div class="flex h-full min-h-64 w-full items-center justify-center text-center text-sm text-gray-300">
                            Trailer not available
                        </div>
                    @endif
                </div>
            </section>

            <div class="order-2 space-y-6 lg:order-2 lg:col-span-6">
                <section class="rounded-lg bg-gray-800/60 p-4">
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="h-40 w-28 shrink-0 overflow-hidden rounded-md bg-gray-700 sm:h-52 sm:w-36">
                                @if($tvshow->poster_image)
                                    <img src="{{ asset("storage/{$tvshow->poster_image}") }}" alt="{{ $tvshow->title }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full w-full items-center justify-center text-sm text-gray-300">Poster</div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h1 class="break-words text-2xl font-bold text-white md:text-3xl">{{ $tvshow->title }}</h1>
                                <div class="mt-2 inline-flex items-center gap-1 text-gray-200">
                                    <i class="fa-solid fa-star text-yellow-400"></i>
                                    <span class="font-semibold">{{ $tvshow->cg_chartbusters_ratings ?? 0 }}/10</span>
                                    <span>({{ $reviews->total() }} Votes)</span>
                                </div>
                                <div class="mt-3 space-y-1 text-sm text-gray-300">
                                    <p>Released: {{ $tvshow->release_date ? \Carbon\Carbon::parse($tvshow->release_date)->format($tvshow->is_release_year_only ? 'Y' : 'd M Y') : 'N/A' }}</p>
                                    <p>Genres: {{ $tvshowGenresText }}</p>
                                    <p>Language: {{ $tvshow->region?->name ?? 'N/A' }}</p>
                                    <p>CBFC: {{ $tvshow->cbfc ?: 'NA' }}</p>
                                </div>
                                <div class="mt-4">
                                    <button onclick="document.getElementById('review-section').scrollIntoView({behavior:'smooth'})"
                                        class="inline-flex items-center gap-2 rounded-lg bg-yellow-500 px-5 py-2 font-black text-black transition-all hover:bg-yellow-600">
                                        <i class="fa-solid fa-star"></i>
                                        Rate This TV Show
                                    </button>
                                </div>
                            </div>
                        </div>
                        <x-social-share :url="url()->current()" :title="$tvshow->title" />
                    </div>
                </section>

                <section class="rounded-lg border border-gray-700 bg-gray-800/30 p-4 sm:p-5">
                    <h3 class="mb-3 text-xl font-semibold text-white">{{ $tvshow->title }} Plot:</h3>
                    <div class="max-h-[32rem] overflow-y-auto whitespace-pre-line text-sm leading-relaxed text-gray-200">
                        @if(app()->getLocale() == 'chh' && !empty($tvshow->content_description_chh))
                            {{ $tvshow->content_description_chh }}
                        @elseif(app()->getLocale() == 'hi' && !empty($tvshow->content_description))
                            {{ $tvshow->content_description }}
                        @else
                            {{ $tvshow->description }}
                        @endif
                    </div>
                </section>
            </div>

            <section class="order-3 lg:order-3 lg:col-span-6">
                <h2 class="mb-4 flex items-center text-lg font-semibold text-white sm:text-xl md:text-2xl">
                    <span class="mr-3 h-6 w-1 bg-yellow-500"></span>Cast
                </h2>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    @foreach ($tvshow->artists as $artist)
                        @php
                            $rolesText = implode(', ', $artist->pivot->category_names);
                        @endphp
                        <div class="cast-member rounded-lg bg-gray-800 p-3 hover:bg-gray-700 sm:p-4">
                            <a href="{{ route('artist.show', $artist->slug) }}" class="flex min-w-0 items-start gap-3">
                                <img src="{{ asset('storage/' . $artist->photo) }}" alt="{{ $artist->name }}"
                                    class="h-14 w-14 rounded-full border-2 border-gray-600 object-cover sm:h-16 sm:w-16">
                                <div class="min-w-0">
                                    <h4 class="text-base font-semibold text-white break-words">{{ $artist->name }}</h4>
                                    <p class="mt-1 text-xs text-gray-300 break-words">{{ $rolesText }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>

            <section id="review-section" class="order-4 lg:order-4 lg:col-span-6">
                <h2 class="mb-4 flex items-center text-lg font-semibold text-white sm:text-xl md:text-2xl">
                    <span class="mr-3 h-6 w-1 bg-yellow-500"></span>Reviews
                </h2>

                <div class="mb-6 rounded-lg bg-gray-800 p-4 sm:p-6">
                    <h3 class="mb-4 text-lg font-bold text-white sm:text-xl">Post a Review</h3>
                    <form action="{{ route('tv-shows.reviews.store', $tvshow) }}" method="POST">
                        @csrf
                        <input type="hidden" name="tvshow_id" value="{{ $tvshow->id }}">

                        <div class="mb-4">
                            <x-input-label for="review_text" :value="__('Review')" class="text-gray-300" />
                            <x-textarea id="review_text"
                                class="mt-2 block w-full rounded-md border-gray-600 bg-gray-700 text-white"
                                name="review_text" rows="4" placeholder="Write your review..."
                                required>{{ old('review_text') }}</x-textarea>
                            <x-input-error :messages="$errors->get('review_text')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="rating" :value="__('Rating')" class="text-gray-300" />
                            <x-star-rating id="rating" class="mt-2 block w-full" name="rating" required></x-star-rating>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <x-input-submit
                            class="w-full rounded-md bg-yellow-500 px-6 py-2 font-semibold text-black transition-colors hover:bg-yellow-600 sm:w-auto">
                            Submit Review
                        </x-input-submit>
                    </form>
                </div>

                <div class="space-y-3 text-gray-200 sm:space-y-4">
                    @foreach($reviews as $review)
                        <div class="review-item rounded-lg border border-gray-700 bg-gray-800 p-3 sm:p-4">
                            <div class="mb-3 flex flex-wrap items-start justify-between gap-2">
                                <div class="flex min-w-0 items-center">
                                    <i class="fa-solid fa-user-circle mr-3 shrink-0 text-2xl text-yellow-400"></i>
                                    <div class="min-w-0">
                                        <strong class="break-words text-yellow-300">
                                            {!! $review->user ? $review->user->name : '<span class="text-gray-500">[deleted account]</span>' !!}
                                        </strong>
                                        <div class="mt-1 flex flex-wrap items-center gap-x-1 gap-y-1">
                                            @for($i = 1; $i <= 10; $i++)
                                                <i class="fa fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }} text-xs"></i>
                                            @endfor
                                            <span class="ml-1 text-xs text-gray-400 sm:text-sm">{{ $review->rating }}/10</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 sm:ml-auto">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <p class="break-words text-gray-300">{{ $review->review_text }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="paginate mt-6 overflow-x-auto">
                    {{ $reviews->links() }}
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
