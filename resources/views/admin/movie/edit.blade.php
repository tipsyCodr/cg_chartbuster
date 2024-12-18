@extends('layouts.admin')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Movie') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Edit Movie
                    </h3>
                </div>
                <div class="bg-white shadow overflow-hidden sm:rounded-md mt-50 px-4 py-5 sm:p-6">
                    <form method="POST" action="{{ route('admin.movies.update', $movie) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-1 gap-6 mb-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Movie Title</label>
                                <input type="text" name="title" id="title" value="{{old('title') ?? $movie->title }}" 
                                    class="mt-1 p-2 block w-full rounded-md @error('title') is-invalid @enderror border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('title')
                                @foreach ($errors->get('title') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2 ">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="3" 
                                    class="mt-1 p-2 block w-full @error('description') is-invalid @enderror rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{old('description') ?? $movie->description }}</textarea>
                                @error('description')
                                @foreach ($errors->get('description') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2 ">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
                            <div>
                                <label for="release_date" class="block text-sm font-medium text-gray-700">Release Date</label>
                                <input type="date" name="release_date" id="release_date" value="{{old('release_date') ?? $movie->release_date }}"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('release_date')
                                @foreach ($errors->get('release_date') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2 ">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                                <input type="text" name="genre" id="genre" value="{{old('genre') ?? $movie->genre }}"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('genre')
                                @foreach ($errors->get('genre') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2 ">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
                                <input type="number" name="duration" id="duration" value="{{old('duration') ?? $movie->duration }}"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('duration')
                                @foreach ($errors->get('duration') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2 ">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="director" class="block text-sm font-medium text-gray-700">Director</label>
                                <input type="text" name="director" id="director" value="{{old('director') ?? $movie->director }}"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('director')
                                @foreach ($errors->get('director') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2 ">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                            <img src="{{ asset('storage/'.$movie->poster_image)}}" alt="{{$movie->title}}">
                                <label for="poster_image" class="block text-sm font-medium text-gray-700">Poster Image</label>
                                <input type="file" name="poster_image" id="poster_image" accept="image/*" 
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('poster_image')
                                @foreach ($errors->get('poster_image') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2 ">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="trailer_url" class="block text-sm font-medium text-gray-700">Trailer URL</label>
                                <input type="url" name="trailer_url" id="trailer_url" value="{{old('trailer_url') ?? $movie->trailer_url }}"
                                    class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('trailer_url')
                                @foreach ($errors->get('trailer_url') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2 ">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
                        </div>
                    </div>

                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
