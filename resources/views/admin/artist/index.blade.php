@extends('layouts.admin')

@section('page-title', 'Artist Management')

@section('content')
    <div x-data="{ showArtistModal: false }" class="container px-3 py-6 mx-auto sm:px-4 sm:py-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-2xl font-bold">Artist Management</h1>
            <button @click="showArtistModal = true"
                class="px-4 py-2 text-white transition rounded bg-accent hover:bg-accent-dark">
                Add New Artist
            </button>
        </div>

        @if(session('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Artist Creation Modal -->
        <div x-show="showArtistModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-0 sm:p-4 outline-none focus:outline-none">
            <div class="relative w-full h-full sm:h-auto sm:max-w-4xl mx-auto flex flex-col sm:my-6">
                <div x-show="showArtistModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative flex flex-col w-full h-full sm:h-auto max-h-screen bg-white sm:rounded-2xl shadow-2xl outline-none focus:outline-none z-60 overflow-hidden">

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                        <h3 class="text-2xl font-semibold">Add New Artist</h3>
                        <button @click="showArtistModal = false"
                            class="float-right p-1 ml-auto text-3xl font-semibold leading-none text-black bg-transparent border-0 outline-none focus:outline-none">
                            <span class="block w-6 h-6 text-2xl text-black bg-transparent">×</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('admin.artists.store') }}" enctype="multipart/form-data" method="POST"
                        class="relative flex-auto p-5 sm:p-8 overflow-y-auto custom-scrollbar">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block mb-1.5 text-sm font-bold text-gray-700">Artist Name</label>
                                    <input type="text" name="name" id="name" required
                                        class="mt-1 block w-full rounded-lg {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="photo" class="block mb-1.5 text-sm font-bold text-gray-700">Artist Photo</label>
                                    <input type="file" name="photo" id="photo" required accept="image/*"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-accent/10 file:text-accent hover:file:bg-accent/20 transition-all">
                                </div>

                                <div>
                                    <label for="birth_date" class="block mb-1.5 text-sm font-bold text-gray-700">Date of Birth</label>
                                    <div class="flex flex-col gap-3">
                                        <input type="date" name="birth_date" id="birth_date"
                                            class="w-full p-2.5 border border-gray-300 rounded-lg text-base shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                                        <div class="flex items-center gap-2">
                                            <input type="hidden" name="is_release_year_only" value="0">
                                            <input type="checkbox" name="is_release_year_only" id="is_release_year_only" value="1" {{ old('is_release_year_only') ? 'checked' : '' }} 
                                                class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent">
                                            <label for="is_release_year_only" class="text-sm font-medium text-gray-600">Show Year Only</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div x-data="{ selected: [] }">
                                    <label class="block mb-1.5 text-sm font-bold text-gray-700">Categories</label>
                                    <div class="p-4 border border-gray-100 rounded-xl bg-gray-50/50 max-h-48 overflow-y-auto custom-scrollbar space-y-2">
                                        @foreach($category as $cat)
                                            <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white transition-colors cursor-pointer group">
                                                <input type="checkbox" value="{{ $cat->id }}" x-model="selected"
                                                    name="category[]" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent">
                                                <span class="text-sm font-medium text-gray-700 group-hover:text-accent transition-colors">
                                                    {{ $cat->name }} <span class="text-xs text-gray-400 group-hover:text-accent/60">({{ $cat->artist_count ?? 0 }})</span>
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="cgcb_rating" class="block mb-1.5 text-sm font-bold text-gray-700">CG Rating</label>
                                    <x-star-rating id="cgcb_rating" class="block w-full" name="cgcb_rating" required></x-star-rating>
                                </div>

                                <div>
                                    <label for="city" class="block mb-1.5 text-sm font-bold text-gray-700">City</label>
                                    <input type="text" name="city" id="city"
                                        class="mt-1 block w-full rounded-lg border-gray-300 text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all">
                                </div>

                                <div>
                                    <label for="bio" class="block mb-1.5 text-sm font-bold text-gray-700">Biography</label>
                                    <textarea name="bio" id="bio" rows="4"
                                        class="mt-1 block w-full rounded-lg border-gray-300 text-base p-2.5 shadow-sm focus:border-accent focus:ring focus:ring-accent/20 transition-all"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                            <button type="button" @click="showArtistModal = false"
                                class="w-full sm:w-auto px-6 py-2.5 text-sm font-bold text-gray-500 uppercase rounded-lg hover:bg-gray-100 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="w-full sm:w-auto px-10 py-2.5 text-sm font-black text-white uppercase rounded-lg shadow-xl bg-accent hover:bg-accent-dark transition-all transform active:scale-95">
                                Save Artist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="fixed inset-0 z-40 bg-black opacity-25 " @click="showArtistModal = false"></div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <livewire:dynamic-search model="Artist" :columns="['photo', 'name', 'category', 'birth_date', 'city']" />

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
