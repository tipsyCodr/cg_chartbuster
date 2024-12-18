@extends('layouts.admin')

@section('page-title', 'Artist Management')

@section('content')
<div x-data="{ showArtistModal: false }" class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Artist Management</h1>
        <button @click="showArtistModal = true" 
           class="bg-accent text-white px-4 py-2 rounded hover:bg-accent-dark transition">
            Add New Artist
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Artist Creation Modal -->
    <div x-show="showArtistModal" 
         x-cloak 
         class="fixed inset-0  flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
        <div class="relative w-auto max-w-3xl mx-auto my-6">
            <div 
                x-show="showArtistModal"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative z-50 flex flex-col w-full bg-white border-0 rounded-lg shadow-lg outline-none focus:outline-none z-60">
                
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-blueGray-200">
                    <h3 class="text-2xl font-semibold">Add New Artist</h3>
                    <button 
                        @click="showArtistModal = false" 
                        class="float-right p-1 ml-auto text-3xl font-semibold leading-none text-black bg-transparent border-0 outline-none opacity-5 focus:outline-none">
                        <span class="block w-6 h-6 text-2xl text-black bg-transparent opacity-5">×</span>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <form action="{{ route('admin.artists.store') }}" enctype="multipart/form-data" method="POST" class="relative flex-auto p-6">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700">Artist Photo</label>
                            <input type="file" name="photo" id="photo" required accept="image/*"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('photo')
                            @foreach ($errors->get('photo') as $message)
                                <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                            @endforeach
                            @enderror
                        </div>
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Artist Name</label>
                            <input type="text" name="name" id="name" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('name')
                            @foreach ($errors->get('name') as $message)
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
                        
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" name="country" id="country" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('country')
                            @foreach ($errors->get('country') as $message)
                                <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                            @endforeach
                            @enderror
                        </div>
                        
                        <div>
                            <label for="bio" class="block text-sm font-medium text-gray-700">Biography</label>
                            <textarea name="bio" id="bio" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            @error('bio')
                            @foreach ($errors->get('bio') as $message)
                                <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                            @endforeach
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="flex items-center justify-end p-6 border-t border-solid rounded-b border-blueGray-200">
                        <button type="button" 
                                @click="showArtistModal = false" 
                                class="px-6 py-2 mr-4 text-sm font-bold text-red-500 uppercase transition-all duration-150 ease-linear bg-transparent rounded outline-none hover:bg-red-100 focus:outline-none">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-6 py-2 text-sm font-bold text-white uppercase bg-accent rounded shadow hover:bg-accent-dark focus:outline-none focus:ring">
                            Save Artist
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="fixed inset-0 z-40 bg-black opacity-25"></div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Photo
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Born On
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Country
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($artists as $artist)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <img class="mt-1 block object-cover w-full rounded-md" src="{{ asset('storage/'.$artist->photo) }}" style="width: 100px; max-height: 300px;" alt="">
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $artist->name }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $artist->birth_date }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            {{ $artist->city }}
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.artists.edit', $artist) }}" 
                                   class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('admin.artists.destroy', $artist) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this artist?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-5 text-center text-gray-500">
                            No artists found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $artists->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
