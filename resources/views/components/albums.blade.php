<div>
    <section class="my-5">
        <h1 class="text-xl font-bold md:text-2xl lg:text-3xl"><span class="mr-3 text-yellow-500 border-4 border-l border-yellow-500"> </span> Albums</h1>
        <div class="flex flex-row gap-2 px-4 py-4 overflow-x-auto scrollbar-hide">
            {{-- Loop through albums if provided, or show message --}}
            @if(isset($albums) && count($albums) > 0)
                @foreach ($albums as $album)
                    <div class="flex-shrink-0 mr-4 transition-all bg-gray-900 rounded-lg shadow-md last:mr-0 ">
                        <div class="relative min-w-48 max-w-48">
                            <img class="object-cover w-full h-56 transition-all duration-300 rounded-t-lg hover:brightness-90"
                                src="{{ Storage::url($album->cover_image) }}" alt="Album Image">
                            <div class="px-4 py-4 bg-gray-900 rounded-b-lg h-30">
                                <h2 class="py-6 overflow-hidden text-sm font-normal text-white normal-case w-38 text-nowrap text-ellipsis">
                                    {{ $album->title }}
                                </h2>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-400">No albums found.</p>
            @endif
        </div>
    </section>
</div>
