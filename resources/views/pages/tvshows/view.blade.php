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

        <!-- Hero Section -->
        <div class="mb-8 grid gap-4 overflow-hidden rounded-xl bg-gray-800 shadow-2xl md:gap-6 lg:grid-cols-3">

            <!-- Left: Media -->
            <div class="hero-section min-w-0 p-2 sm:p-4 lg:col-span-2">
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
                        <div class="flex h-full w-full items-center justify-center text-center text-sm text-gray-300">
                            Trailer not available
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: TV Show Info -->
            <div class="lg:col-span-1 p-4 sm:p-6 flex flex-col justify-between">
                <div>
                    <h1 class="mb-4 break-words text-2xl font-bold text-white md:text-3xl">{{ $tvshow->title }}</h1>
                    <div class="mb-4 inline-flex items-center gap-1 rounded-full bg-gray-700/60 px-3 py-1 text-xs text-gray-200">
                        <img src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating" class="w-4 h-4">
                        <span>{{ $tvshow->cg_chartbusters_ratings }} / 10 Ratings</span>
                    </div>
                    <div class="grid grid-cols-1 gap-2 text-sm sm:grid-cols-2">
                        <div class="rounded-lg bg-gray-700/40 p-2">
                            <p class="text-[11px] uppercase tracking-wide text-gray-400">Released</p>
                            <p class="text-gray-100">
                                @if($tvshow->release_date)
                                    {{ \Carbon\Carbon::parse($tvshow->release_date)->format($tvshow->is_release_year_only ? 'Y' : 'd M Y') }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <div class="rounded-lg bg-gray-700/40 p-2 sm:col-span-2">
                            <p class="text-[11px] uppercase tracking-wide text-gray-400">Genre</p>
                            <div x-data="{ expanded: false }" class="text-gray-100">
                                <p class="break-words">
                                    <span x-show="!expanded">{{ \Illuminate\Support\Str::limit($tvshowGenresText, 70) }}</span>
                                    <span x-show="expanded">{{ $tvshowGenresText }}</span>
                                </p>
                                @if(\Illuminate\Support\Str::length($tvshowGenresText) > 70)
                                    <button type="button" @click="expanded = !expanded"
                                        class="mt-1 text-xs font-semibold text-yellow-300 hover:text-yellow-200">
                                        <span x-show="!expanded">Show more</span>
                                        <span x-show="expanded">Show less</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="rounded-lg bg-gray-700/40 p-2">
                            <p class="text-[11px] uppercase tracking-wide text-gray-400">Language</p>
                            <p class="text-gray-100">{{ $tvshow->region?->name ?? 'N/A' }}</p>
                        </div>
                        @if(!empty($tvshow->duration) && !in_array($tvshow->duration, ['00:00', '00:00:00', '05:00', '00:05:00']))
                            <div class="rounded-lg bg-gray-700/40 p-2">
                                <p class="text-[11px] uppercase tracking-wide text-gray-400">Duration</p>
                                <p class="text-gray-100">{{ substr($tvshow->duration, 0, 5) }} Hrs</p>
                            </div>
                        @endif
                        <div class="rounded-lg bg-gray-700/40 p-2">
                            <p class="text-[11px] uppercase tracking-wide text-gray-400">CBFC</p>
                            <p class="text-gray-100">{{ $tvshow->cbfc }}</p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-lg bg-gray-700/30 p-3">
                        <h3 class="mb-2 text-base font-semibold text-white sm:text-lg">Plot</h3>
                        <div class="text-sm leading-relaxed text-gray-200 lg:max-h-44 lg:overflow-y-auto whitespace-pre-line">
                            @if(app()->getLocale() == 'chh' && !empty($tvshow->content_description_chh))
                                {{ $tvshow->content_description_chh }}
                            @elseif(app()->getLocale() == 'hi' && !empty($tvshow->content_description))
                                {{ $tvshow->content_description }}
                            @else
                                {{ $tvshow->description }}
                            @endif
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-700/40">
                            <button onclick="document.getElementById('review-section').scrollIntoView({behavior:'smooth'})" 
                                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-yellow-500 text-black font-black rounded-lg hover:bg-yellow-600 transition-all shadow-xl active:scale-95 group">
                                <i class="fa-solid fa-star transition-transform group-hover:rotate-12"></i>
                                Rate This TV Show
                            </button>
                            <x-social-share :url="url()->current()" :title="$tvshow->title" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section: Cast & Reviews -->
        <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">

            <!-- Cast -->
            <div class="lg:col-span-2 py-5">
                <h2 class="mb-6 flex items-center text-lg font-semibold text-white sm:text-xl md:text-2xl">
                    <span class="w-1 h-6 bg-yellow-500 mr-3"></span>Cast & Roles
                </h2>

                <div class="grid grid-cols-1 gap-3 sm:gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($tvshow->artists as $artist)
                        @php
                            $rolesText = implode(', ', $artist->pivot->category_names);
                        @endphp
                        <div class="cast-member rounded-lg bg-gray-800 p-3 hover:bg-gray-700 sm:p-4">
                            <a href="{{ route('artist.show', $artist->slug) }}" class="flex min-w-0 items-start gap-3">
                                <img src="{{ asset('storage/' . $artist->photo) }}" alt="{{ $artist->name }}"
                                    class="w-14 h-14 rounded-full object-cover border-2 border-gray-600 sm:h-16 sm:w-16">
                                <div class="min-w-0">
                                    <h4 class="text-base font-semibold text-white break-words">{{ $artist->name }}</h4>
                                </div>
                            </a>
                            <div x-data="{ expanded: false }" class="mt-2">
                                <p class="text-xs text-gray-400 sm:text-sm break-words">
                                    <span class="font-semibold text-gray-300">Roles: </span>
                                    <span x-show="!expanded">{{ \Illuminate\Support\Str::limit($rolesText, 56) }}</span>
                                    <span x-show="expanded">{{ $rolesText }}</span>
                                </p>
                                @if(\Illuminate\Support\Str::length($rolesText) > 56)
                                    <button type="button" @click="expanded = !expanded"
                                        class="mt-1 text-xs font-semibold text-yellow-300 hover:text-yellow-200">
                                        <span x-show="!expanded">Show more</span>
                                        <span x-show="expanded">Show less</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Reviews -->
            <div class="py-5 lg:sticky lg:top-6 lg:self-start">
                <h2 class="mb-6 flex items-center text-lg font-semibold text-white sm:text-xl md:text-2xl">
                    <span class="w-1 h-6 bg-yellow-500 mr-3"></span>Reviews
                </h2>

                <!-- Review Form -->
                <div class="bg-gray-800 rounded-lg p-4 mb-6 sm:p-6">
                    <h3 class="mb-4 text-lg font-bold text-white sm:text-xl">Post a Review</h3>
                    <form action="{{ route('tv-shows.reviews.store', $tvshow) }}" method="POST">
                        @csrf
                        <input type="hidden" name="tvshow_id" value="{{ $tvshow->id }}">

                        <div class="mb-4">
                            <x-input-label for="review_text" :value="__('Review')" class="text-gray-300" />
                            <x-textarea id="review_text"
                                class="block mt-2 w-full bg-gray-700 border-gray-600 text-white rounded-md"
                                name="review_text" rows="4" placeholder="Write your review..."
                                required>{{ old('review_text') }}</x-textarea>
                            <x-input-error :messages="$errors->get('review_text')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="rating" :value="__('Rating')" class="text-gray-300" />
                            <x-star-rating id="rating" class="block mt-2 w-full" name="rating" required></x-star-rating>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <x-input-submit
                            class="w-full rounded-md bg-yellow-500 px-6 py-2 font-semibold text-black transition-colors hover:bg-yellow-600 sm:w-auto">
                            Submit Review
                        </x-input-submit>
                    </form>
                </div>

                <!-- Reviews List -->
                <div class="space-y-3 text-gray-200 sm:space-y-4">
                    @foreach($reviews as $review)
                        <div class="review-item rounded-lg border border-gray-700 bg-gray-800 p-3 sm:p-4">
                            <div class="flex flex-wrap items-start justify-between gap-2 mb-3">
                                <div class="flex items-center min-w-0">
                                    <i class="fa-solid fa-user-circle text-yellow-400 text-2xl mr-3 shrink-0"></i>
                                    <div class="min-w-0">
                                        <strong class="break-words text-yellow-300">
                                            {!! $review->user ? $review->user->name : '<span class="text-gray-500">[deleted account]</span>' !!}
                                        </strong>
                                        <div class="mt-1 flex flex-wrap items-center gap-x-1 gap-y-1">
                                            @for($i = 1; $i <= 10; $i++)
                                                <i
                                                    class="fa fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }} text-xs"></i>
                                            @endfor
                                            <span class="ml-1 text-xs text-gray-400 sm:text-sm">{{ $review->rating }}/10</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 sm:ml-auto">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <p class="leading-relaxed text-gray-300 break-words">{{ $review->review_text }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="paginate mt-6 overflow-x-auto">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
