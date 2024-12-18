@extends('layouts.admin')

@section('content')
<div x-data="{ showMovieModal: false }" class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Movie Management</h1>
        <button @click="showMovieModal = true"
            class="bg-accent text-white px-4 py-2 rounded hover:bg-accent-dark transition">
            Add New Movie
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-500">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @error('title', 'description', 'year', 'genre', 'director', 'cast', 'duration', 'poster', 'trailer')
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong>{{ $message }}</strong>
        </div>
    @enderror

    <!-- Movie Creation Modal -->
    <div x-show="showMovieModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-start justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
        <div class="relative w-auto max-w-3xl mx-auto my-6">
            <div
                x-show="showMovieModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none z-60">

                <!-- Modal Header -->
                <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                    <h3 class="text-2xl font-semibold">Add New Movie</h3>
                    <button
                        @click="showMovieModal = false"
                        class="float-right p-1 ml-auto text-3xl font-semibold leading-none text-black bg-transparent border-0 outline-none opacity-5 focus:outline-none">
                        <span class="block w-6 h-6 text-2xl text-black bg-transparent opacity-5">×</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data" class="relative flex-auto p-6">
                    @csrf
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-1 gap-6 mb-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Movie Title</label>
                                <input type="text" name="title" id="title" required
                                    class="mt-1 block w-full rounded-md @error('title') is-invalid @enderror border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('title')
                                @foreach ($errors->get('title') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    class="mt-1 block w-full @error('description') is-invalid @enderror rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                @error('description')
                                @foreach ($errors->get('description') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
                            <div>
                                <label for="release_date" class="block text-sm font-medium text-gray-700">Release Date</label>
                                <input type="date" name="release_date" id="release_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('release_date')
                                @foreach ($errors->get('release_date') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                                <input type="text" name="genre" id="genre"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('genre')
                                @foreach ($errors->get('genre') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                        </div>

                        <div class="grid grid-cols-1 gap-6">

                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
                                <input type="number" name="duration" id="duration"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('duration')
                                @foreach ($errors->get('duration') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="director" class="block text-sm font-medium text-gray-700">Director</label>
                                <input type="text" name="director" id="director"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('director')
                                @foreach ($errors->get('director') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="poster_image" class="block text-sm font-medium text-gray-700">Poster Image</label>
                                <input type="file" name="poster_image" id="poster_image" accept="image/*"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('poster_image')
                                @foreach ($errors->get('poster_image') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="trailer_url" class="block text-sm font-medium text-gray-700">Trailer URL</label>
                                <input type="url" name="trailer_url" id="trailer_url"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('trailer_url')
                                @foreach ($errors->get('trailer_url') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
                        <button type="button"
                            @click="showMovieModal = false"
                            class="px-6 py-2 mr-4 text-sm font-bold text-red-500 uppercase transition-all duration-150 ease-linear bg-transparent rounded outline-none hover:bg-red-100 focus:outline-none">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-bold text-white uppercase bg-accent rounded shadow hover:bg-accent-dark focus:outline-none focus:ring">
                            Save Movie
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="fixed inset-0  bg-black opacity-25 -z-10 backdrop-blur-lg"></div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Poster
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Title
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Release Year
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($movies as $movie)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <img src="{{ Storage::url($movie->poster_image) }}" alt="{{ $movie->title }}" class="w-16 h-24 object-cover rounded">
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $movie->title }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        {{ $movie->release_date }}
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.movies.edit', $movie) }}"
                                class="text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this movie?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-5 py-5 text-center text-gray-500">
                        No movies found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>    

        <div class="flex p-2 justify-center space-x-4">
            {{ $movies->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@endpush