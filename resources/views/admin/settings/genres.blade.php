@extends('layouts.admin')

@section('page-title', 'Genres')

@section('content')
    <div x-data="{ 
        showModal: {{ $errors->any() ? 'true' : 'false' }}, 
        editMode: {{ old('edit_mode') ? 'true' : 'false' }}, 
        genreId: '{{ old('genre_id') }}', 
        genreName: '{{ old('name') }}',
        genreFor: '{{ old('for') }}'
    }" class="container px-4 py-8 mx-auto">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold">Genre Management</h1>
            <button @click="showModal = true; editMode = false; genreName = ''; genreId = ''; genreFor = ''"
                class="px-4 py-2 text-white transition rounded bg-accent hover:bg-accent-dark">
                Add New Genre
            </button>
        </div>

        @if (session('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <div class="overflow-x-auto">
            <table class="min-w-[700px] w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase text-black">ID</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase text-black">Category (For)</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase text-black">Name</th>
                        <th class="px-6 py-3 text-xs font-medium text-right text-gray-500 uppercase text-black">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($genres as $genre)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-black">{{ $genre->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-black">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $genre->for }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-black">{{ $genre->name }}</td>
                            <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                <button @click="showModal = true; editMode = true; genreId = '{{ $genre->id }}'; genreName = '{{ $genre->name }}'; genreFor = '{{ $genre->for }}'"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </button>
                                <form action="{{ route('admin.genres.destroy', $genre->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this genre?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No genres found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="showModal" x-cloak
            class="fixed inset-0 z-50 flex items-start justify-center overflow-x-hidden overflow-y-auto px-3 py-6 outline-none focus:outline-none sm:px-4 sm:py-10">
            <div class="relative w-full max-w-lg mx-auto">
                <div x-show="showModal" @click.away="showModal = false"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-xl outline-none focus:outline-none">

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-black" x-text="editMode ? 'Edit Genre' : 'Add New Genre'"></h3>
                        <button @click="showModal = false"
                            class="p-1 ml-auto bg-transparent border-0 text-gray-400 float-right text-3xl leading-none font-semibold outline-none focus:outline-none hover:text-gray-600">
                            <span>×</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form :action="editMode ? `/admin/genres/${genreId}` : '{{ route('admin.genres.store') }}'" method="POST" class="p-4 sm:p-6">
                        @csrf
                        <template x-if="editMode">
                            @method('PUT')
                        </template>
                        
                        <input type="hidden" name="genre_id" x-model="genreId">
                        <input type="hidden" name="edit_mode" x-model="editMode">

                        <div class="mb-4">
                            <label for="for" class="block text-sm font-medium text-gray-700 mb-1">Category (For)</label>
                            <select name="for" id="for" x-model="genreFor" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 text-black">
                                <option value="">Select Category</option>
                                <option value="Movies">Movies</option>
                                <option value="Songs">Songs</option>
                                <option value="TV Shows">TV Shows</option>
                                <option value="Albums">Albums</option>
                            </select>
                            @error('for')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Genre Name</label>
                            <input type="text" name="name" id="name" x-model="genreName" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror text-black">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Modal Footer -->
                        <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-end sm:space-x-3 sm:gap-0">
                            <button type="button" @click="showModal = false"
                                class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto">
                                Cancel
                            </button>
                            <button type="submit"
                                class="w-full px-4 py-2 text-sm font-medium text-white bg-accent rounded-md shadow-sm hover:bg-accent-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto">
                                <span x-text="editMode ? 'Update Genre' : 'Save Genre'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity -z-10 backdrop-blur-sm" @click="showModal = false"></div>
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
