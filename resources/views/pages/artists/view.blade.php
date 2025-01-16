<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Artist Details') }}
        </h2>
    </x-slot>
    
    <div class="px-5 py-6">
        <!-- Artist Profile Section -->
        <div class="flex flex-col items-start gap-6 lg:flex-row">
            <!-- Artist Photo -->
            <div class="flex gap-4">
                <img
                    class="object-cover rounded-md shadow-md w-52 h-52"
                    src="{{ $artists->photo ? asset('storage/'.$artists->photo) : asset('images/placeholder.png') }}"
                    alt="{{ $artists->name }}">
                    <div class="">
                        <h1 class="text-3xl font-bold text-gray-100">{{ $artists->name }}</h1>
                        <p class="mt-2 text-sm text-gray-200">{{ $artists->category }}</p>
        
                        <!-- Birth Date -->
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-100">Date of Birth</h3>
                            <p class="text-gray-200">{{ \Carbon\Carbon::parse($artists->birth_date)->format('F j, Y') }}</p>
                        </div>
                    <!-- Biography -->
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-100">Biography</h3>
                            <p class="mt-2 text-gray-200">{{ $artists->bio }}</p>
                        </div>
                    </div>
            </div>

          
        </div>
        <!-- Artist Movies Section -->
        <div class="mt-8">
            <h3 class="text-2xl font-semibold text-gray-100">Movies</h3>
            <ul class="mt-4 space-y-2">
            @if($artists->movies->isEmpty())
                <li class="text-gray-200">No movies found</li>
            @else
                @foreach($artists->movies as $movie)
                    <li class="text-gray-200">{{ $movie->title }} ({{ \Carbon\Carbon::parse($movie->release_date)->format('Y') }})</li>
                @endforeach
            @endif
            </ul>
        </div>

        <!-- Artist Songs Section -->
        {{-- <div class="mt-8">
            <h3 class="text-2xl font-semibold text-gray-800">Songs</h3>
            <ul class="mt-4 space-y-2">
            @foreach($artists->songs as $song)
                <li class="text-gray-700">{{ $song->title }} ({{ \Carbon\Carbon::parse($song->release_date)->format('Y') }})</li>
            @endforeach
            </ul>
        </div> --}}

    </div>
</x-app-layout>
