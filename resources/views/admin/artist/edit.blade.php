@extends('layouts.admin')

@section('page-title', 'Artist Management')

@section('content')


    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif


   <div class="bg-white shadow rounded p-2">
       <!-- Modal Body -->
       <form action="{{ route('admin.artists.update', $artist) }}" enctype="multipart/form-data" method="POST" class="relative flex-auto p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <img class="mt-1 block object-cover w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" src="{{ asset('storage/'.$artist->photo) }}" style="width: 200px; max-height: 300px;" alt="">
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Artist Photo</label>
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="">
                                @error('photo')
                                @foreach ($errors->get('photo') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Artist Name</label>
                                <input type="text" name="name" id="name" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="{{ $artist->name }}">
                                @error('name')
                                @foreach ($errors->get('name') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
       
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Birth Date</label>
                                <input type="date" name="birth_date" id="birth_date"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="{{ $artist->birth_date }}">
                                @error('birth_date')
                                @foreach ($errors->get('birth_date') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
       
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" name="city" id="city"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="{{ $artist->city }}">
                                @error('city')
                                @foreach ($errors->get('city') as $message)
                                    <div class="text-red-500 bg-red-100 border-red-500 rounded p-2">{{ $message }}</div>
                                @endforeach
                                @enderror
                            </div>
       
                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700">Biography</label>
                                <textarea name="bio" id="bio" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $artist->bio }}</textarea>
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
                                    onclick="window.history.back()"
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
@endsection

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
