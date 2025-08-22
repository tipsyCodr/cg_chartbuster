@extends('layouts.admin')

@section('page-title', 'Artist Management')

@section('content')
    <div x-data="{ showArtistModal: false }" class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-6">
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
            class="fixed inset-0 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
            <div class="relative w-full max-w-6xl mx-auto my-6">
                <div x-show="showArtistModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative z-50 flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none z-60">

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
                        class="relative flex-auto p-6">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Artist Photo</label>
                                <input type="file" name="photo" id="photo" required accept="image/*"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('photo')
                                    @foreach ($errors->get('photo') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Artist Name</label>
                                <input type="text" name="name" id="name" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('name')
                                    @foreach ($errors->get('name') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>
                             <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="birth_date" id="birth_date"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="">
                                @error('birth_date')
                                @foreach ($errors->get('birth_date') as $message)
                                    <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>

                            <div x-data="{ selected: [] }" >
                                <label class="block text-sm font-medium text-gray-700 mb-2" >Categories</label>
                                <div class="space-y-2 bg-gray-300 p-2" style='height:200px;overflow-y: auto;'>
                                    @foreach($category as $cat)
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" value="{{ $cat->id }}" x-model="selected"
                                                name="category[]">
                                            <span>{{ $cat->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <x-star-rating id="cgcb_rating" class="block mt-1 w-full" name="cgcb_rating" required></x-star-rating>


                            {{-- <div>
                                <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                                <input type="text" name="genre" id="genre"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('genre')
                                @foreach ($errors->get('genre') as $message)
                                <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div> --}}

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" id="city"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('city')
                                    @foreach ($errors->get('city') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700">Biography</label>
                                <textarea name="bio" id="bio" rows="3"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                                @error('bio')
                                    @foreach ($errors->get('bio') as $message)
                                        <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                    @endforeach
                                @enderror
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
                            <button type="button" @click="showArtistModal = false"
                                class="px-6 py-2 mr-4 text-sm font-bold text-red-500 uppercase transition-all duration-150 ease-linear bg-transparent rounded outline-none hover:bg-red-100 focus:outline-none">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 text-sm font-bold text-white uppercase rounded shadow bg-accent hover:bg-accent-dark focus:outline-none focus:ring">
                                Save Artist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="fixed inset-0 z-40 bg-black opacity-25 " @click="showArtistModal = false"></div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <livewire:dynamic-search model="Artist" :columns="['photo', 'name', 'birth_date', 'city']" />

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