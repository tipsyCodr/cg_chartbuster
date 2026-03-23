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
            class="fixed inset-0 z-50 flex items-start justify-center overflow-x-hidden overflow-y-auto px-2 py-4 outline-none focus:outline-none sm:px-4 sm:py-6">
            <div class="relative w-full max-w-6xl mx-auto my-2 sm:my-6">
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
                        class="relative flex-auto p-4 sm:p-6">
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
                                    <div class="flex items-center mt-2">
                                        <input type="hidden" name="is_release_year_only" value="0">
                                        <input type="checkbox" name="is_release_year_only" id="is_release_year_only" value="1" {{ old('is_release_year_only') ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                                        <label for="is_release_year_only" class="block ml-2 text-sm text-gray-900">Show Year Only</label>
                                    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('is_release_year_only');
        const dateInput = document.getElementById('release_date') || document.getElementById('birth_date');
        function toggleDateInput() {
            if (checkbox.checked) {
                if (dateInput.value && dateInput.value.includes('-')) {
                    dateInput.dataset.fullDate = dateInput.value;
                    dateInput.value = dateInput.value.split('-')[0];
                }
                dateInput.type = 'number';
                dateInput.min = '1900';
                dateInput.max = '2100';
                dateInput.placeholder = 'YYYY';
            } else {
                dateInput.type = 'date';
                dateInput.removeAttribute('min');
                dateInput.removeAttribute('max');
                dateInput.removeAttribute('placeholder');
                if (dateInput.dataset.fullDate && !dateInput.value.includes('-')) {
                    dateInput.value = dateInput.dataset.fullDate;
                } else if (dateInput.value && !dateInput.value.includes('-') && dateInput.value.length === 4) {
                    dateInput.value = dateInput.value + '-01-01';
                }
            }
        }
        if (checkbox && dateInput) {
            checkbox.addEventListener('change', toggleDateInput);
            toggleDateInput();
            const form = dateInput.closest('form');
            if (form) {
                form.addEventListener('submit', function() {
                    if (checkbox.checked && dateInput.value && !dateInput.value.includes('-')) {
                        dateInput.type = 'text';
                        dateInput.value = dateInput.value + '-01-01';
                    }
                });
            }
        }
    });
</script>
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
                                            <span>{{ $cat->name }} ({{ $cat->artist_count ?? 0 }})</span>
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
                        <div class="flex flex-col-reverse gap-2 p-4 border-t border-solid rounded-b border-blueGray-200 sm:flex-row sm:items-center sm:justify-end sm:p-6">
                            <button type="button" @click="showArtistModal = false"
                                class="w-full px-6 py-2 text-sm font-bold text-red-500 uppercase transition-all duration-150 ease-linear bg-transparent rounded outline-none hover:bg-red-100 focus:outline-none sm:mr-4 sm:w-auto">
                                Cancel
                            </button>
                            <button type="submit"
                                class="w-full px-6 py-2 text-sm font-bold text-white uppercase rounded shadow bg-accent hover:bg-accent-dark focus:outline-none focus:ring sm:w-auto">
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
