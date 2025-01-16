@extends('layouts.admin')

@section('page-title', 'Artist Management')

@section('content')


    @if(session('success'))
        <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif


   <div class="p-2 bg-white rounded shadow">
       <!-- Modal Body -->
       <form action="{{ route('admin.artists.update', $artist) }}" enctype="multipart/form-data" method="POST" class="relative flex-auto p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <img class="block object-cover w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" src="{{ asset('storage/'.$artist->photo) }}" style="width: 200px; max-height: 300px;" alt="">
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Artist Photo</label>
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="">
                                @error('photo')
                                @foreach ($errors->get('photo') as $message)
                                    <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Artist Name</label>
                                <input type="text" name="name" id="name" required
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="{{ $artist->name }}">
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
                                    <option value="{{ $name->name }}">{{ $name->name }}</option>
                                @endforeach
                                </select>
                                @error('category')
                                @foreach ($errors->get('category') as $message)
                                    <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                                <input type="date" name="birth_date" id="birth_date"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="{{ $artist->birth_date }}">
                                @error('birth_date')
                                @foreach ($errors->get('birth_date') as $message)
                                    <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
       
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" id="city"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="{{ $artist->city }}">
                                @error('city')
                                @foreach ($errors->get('city') as $message)
                                    <div class="p-2 text-red-500 bg-red-100 border-red-500 rounded">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
       
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700">Biography</label>
                                <textarea name="bio" id="bio" rows="3"
                                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $artist->bio }}</textarea>
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
                                    onclick="window.history.back()"
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
@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
