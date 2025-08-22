<x-app-layout>

    <section class="mt-9  min-h-[50vh]">
        <h1 class="text-2xl font-bold flex ">Artists
        </h1>
           
            <form action="{{ route('artists') }}" method="GET" class="mb-6 flex gap-3 flex-wrap justify-center lg:justify-start items-center">
                <label for="category" class="text-gray-200">Filter by Category:</label>
                <select name="category" id="category" onchange="this.form.submit()"
                    class="px-4 py-2 bg-gray-800 border border-gray-700 rounded text-white">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (isset($categoryId) && $categoryId == $cat->id) ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </form>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($artists as $artist)
                <div
                    class="text-center rounded-lg overflow-hidden shadow hover:shadow-lg transition p-4 flex flex-col justify-center items-center">

                    {{-- Artist Photo --}}
                    <a href="{{ route('artist.show', $artist) }}">

                        <img src="{{ asset('storage/' . $artist->photo) }}" alt="{{ $artist->name }}"
                            class="w-56 h-56 object-cover rounded-full mb-3">
                    </a>

                    {{-- Artist Info --}}
                    <div class="flex flex-col gap-1 w-full">
                        <a href="{{ route('artist.show', $artist) }}"
                            class="font-bold text-lg sm:text-xl text-gray-100 hover:text-gray-300 truncate">
                            {{ $artist->name }}
                        </a>

                        {{-- CG Chartbusters Rating --}}
                        @if($artist->cgcb_rating)
                            <div class="flex justify-center items-center gap-1 text-xs text-gray-300">
                                <img src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating" class="w-4 h-4">
                                <span>{{ $artist->cgcb_rating }} / 10 Ratings</span>
                            </div>
                        @endif

                        {{-- Birthdate --}}
                        <p class="text-gray-400 text-xs">
                            Born on: {{ \Carbon\Carbon::parse($artist->birth_date)->format('F j, Y') }}
                        </p>

                        {{-- City --}}
                        <p class="text-gray-400 text-xs">{{ $artist->city }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </section>

</x-app-layout>