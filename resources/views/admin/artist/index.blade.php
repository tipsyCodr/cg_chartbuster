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
    <div x-show="showArtistModal" 
         x-cloak 
         class="fixed inset-0 flex items-center justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none">
        <div class="relative w-full max-w-6xl mx-auto my-6">
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
                        class="float-right p-1 ml-auto text-3xl font-semibold leading-none text-black bg-transparent border-0 outline-none focus:outline-none">
                        <span class="block w-6 h-6 text-2xl text-black bg-transparent">×</span>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <form action="{{ route('admin.artists.store') }}" enctype="multipart/form-data" method="POST" class="relative flex-auto p-6">
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
                        <div class="">
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category" id="category" required 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Category</option>
                               
                            @foreach($category as $name)
                                <option value="{{ $name->id }}">{{ $name->name }}</option>
                            @endforeach
                            </select>
                            @error('category')
                            @foreach ($errors->get('category') as $message)
                                <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                            @endforeach
                            @enderror
                        </div>
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                            <input type="text" name="genre" id="genre" 
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('genre')
                            @foreach ($errors->get('genre') as $message)
                                <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                            @endforeach
                            @enderror
                        </div>
                        
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" name="country" id="country" 
                                   class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('country')
                            @foreach ($errors->get('country') as $message)
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
                        <button type="button" 
                                @click="showArtistModal = false" 
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
        <div class="fixed inset-0 z-40 bg-black opacity-25 "  @click="showArtistModal = false"  ></div>
    </div>

    <div class="overflow-hidden bg-white rounded-lg shadow-md">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Photo
                    </th>
                    <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Name
                    </th>
                    <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Born On
                    </th>
                    <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Country
                    </th>
                    <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($artists as $artist)
                    <tr>
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                            <img class="block object-cover w-full mt-1 rounded-md" src="{{ asset('storage/'.$artist->photo) }}" style="width: 100px; max-height: 300px;" alt="">
                        </td>
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                            {{ $artist->name }}
                        </td>
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                            {{ $artist->birth_date }}
                        </td>
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                            {{ $artist->city }}
                        </td>
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
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
