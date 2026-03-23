<x-app-layout>

    <section class="mt-8 min-h-[50vh]">
        <h1 class="text-2xl font-bold">Artists</h1>

        <form action="{{ route('artists') }}" method="GET"
            class="mb-6 mt-3 flex gap-3 flex-wrap justify-start items-center">
            <label for="category" class="text-gray-200">Filter by Category:</label>
            <select name="category" id="category" onchange="this.form.submit()"
                class="w-full sm:w-auto px-4 py-2 bg-gray-800 border border-gray-700 rounded text-white sm:min-w-52">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ (isset($categoryInput) && $categoryInput == $cat->slug) ? 'selected' : '' }}>
                        {{ $cat->name }} ({{ $cat->artist_count ?? 0 }})
                    </option>
                @endforeach
            </select>
        </form>

        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($artists as $artist)
                <div
                    class="text-center rounded-lg overflow-hidden shadow hover:shadow-lg transition p-4 flex flex-col justify-center items-center">

                    {{-- Artist Photo --}}
                    <a href="{{ route('artist.show', $artist->slug) }}">

                        <img src="{{ asset('storage/' . $artist->photo) }}" alt="{{ $artist->name }}"
                            class="h-40 w-40 object-cover rounded-full mb-3 sm:h-48 sm:w-48 lg:h-56 lg:w-56">
                    </a>

                    {{-- Artist Info --}}
                    <div class="flex flex-col gap-1 w-full">
                        <a href="{{ route('artist.show', $artist->slug) }}"
                            class="font-bold text-lg sm:text-xl text-gray-100 hover:text-gray-300 break-words">
                            {{ $artist->name }}
                        </a>
                        <a href="{{ route('artist.show', $artist->slug) }}" class="block w-full px-2 py-2 my-2 font-bold text-center text-white bg-gray-700 rounded-full hover:bg-gray-600 active:bg-gray-500">Details</a>

                        {{-- CG Chartbusters Rating --}}
                        @if($artist->cgcb_rating)
                            <div class="flex justify-center items-center gap-1 text-xs text-gray-300">
                                <img src="{{ asset('images/badge.png') }}" alt="CG Chartbusters Rating" class="w-4 h-4">
                                <span>{{ $artist->cgcb_rating }} / 10 Ratings</span>
                            </div>
                        @endif

                        {{-- Birthdate --}}
                        <p class="text-gray-400 text-xs">
                            {{-- {{ \Carbon\Carbon::parse($artist->birth_date)->format('F j, Y') }} --}}
                            Born on:
                            {{ $artist->birth_date ? \Carbon\Carbon::parse($artist->birth_date)->format($artist->is_release_year_only ? 'Y' : 'F j, Y') : 'N/A' }}
                        </p>

                        {{-- City --}}
                        <p class="text-gray-400 text-xs">{{ $artist->city }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </section>

</x-app-layout>
