@extends('layouts.admin')

@section('page-title', 'Album Management')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.albums.update', $album->id) }}" method="POST" class="relative flex-auto p-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Album Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $album->title) }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('title')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="release_date" class="block text-sm font-medium text-gray-700">Release Date</label>
                <input type="date" name="release_date" id="release_date" value="{{ old('release_date', $album->release_date) }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('release_date')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            
            <div>
                <label for="artist_id" class="block text-sm font-medium text-gray-700">artist_id</label>
                <input type="text" name="genre" id="genre" value="{{ old('genre', $album->genre) }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @error('genre')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="artist_id" class="block text-sm font-medium text-gray-700">Album Artists</label>
                <select multiple name="artist_id[]" id="artist_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    @foreach ($artists as $artist)
                        <option value="{{ $artist->id }}" {{ in_array($artist->id, old('artist_id', $album->artists ? $album->artists->pluck('id')->toArray() : [])) ? 'selected' : '' }}>{{ $artist->name }}</option>
                    @endforeach
                </select>
                @error('artist_id')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <h2>Album Artists</h2>
        <div class="flex">
            <ul class="flex flex-wrap">
                @foreach ($artist_names as $artist)
                    <li class="bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $artist }}</li>
                @endforeach
            </ul>

        </div>


        <!-- Modal Footer -->
        <div class="flex items-center justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
            <button type="button" 
                    @click="showAlbumModal = false" 
                    class="px-6 py-2 mr-4 text-sm font-bold text-red-500 uppercase transition-all duration-150 ease-linear bg-transparent rounded outline-none hover:bg-red-100 focus:outline-none">
                Cancel
            </button>
            <button type="submit" 
                    class="px-6 py-2 text-sm font-bold text-white uppercase bg-accent rounded shadow hover:bg-accent-dark focus:outline-none focus:ring">
                Save Album
            </button>
        </div>
    </form>

@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
