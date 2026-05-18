<div>
    <section class="pb-32 mt-5">
        <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"> <span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Artists</h1>
        <div class="flex flex-row gap-5 px-4 py-4 overflow-x-auto scrollbar-hide">
            @php
                $phCatComp = \App\Models\ArtistCategory::where('slug', 'production-house')->first();
                $phCategoryIdComp = $phCatComp ? (string) $phCatComp->id : '-1';
            @endphp
            @foreach ($artists as $artist)
                @php
                    $isPH = is_array($artist->category)
                        ? in_array($phCategoryIdComp, $artist->category)
                        : ($artist->category == $phCategoryIdComp);
                    $showRoute = $isPH ? route('production-house.show', $artist->slug) : route('artist.show', $artist->slug);
                @endphp
                <a href="{{ $showRoute }}" class="flex flex-col items-center">
                    <div class="relative flex-shrink-0 transition-all group">
                        <div class="w-40 h-40 overflow-hidden rounded-full ">
                            <img class="object-cover w-full h-full transition-transform duration-300 group-hover:scale-110"
                                src="{{ Storage::url($artist->photo) }}" alt="Artist Image">
                        </div>
                    </div>
                    <h3 class="mt-4 text-lg text-center text-white">{{ ucwords(strtolower($artist->name)) }}</h3>
                    <div class="flex justify-start items-center gap-1 text-xs mb-4 text-gray-300">
                        <img src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating" class="w-4 h-4">
                        <span>{{ $artist->cgcb_rating ?? 0}} / 10 Ratings</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</div>
