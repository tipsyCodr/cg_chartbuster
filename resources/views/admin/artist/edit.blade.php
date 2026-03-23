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

                            
                            
                            
                            <div x-data="{ selected: @json($artist->category ?? []) }" >
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
                            <x-star-rating id="cgcb_rating" class="block mt-1 w-full" :value="$artist->cgcb_rating ?? old('cgcb_rating')"  name="cgcb_rating" required></x-star-rating>
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="birth_date" id="birth_date"
                                       class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                       value="{{ $artist->birth_date?->format('Y-m-d') }}">
                                    <div class="flex items-center mt-2">
                                        <input type="hidden" name="is_release_year_only" value="0">
                                        <input type="checkbox" name="is_release_year_only" id="is_release_year_only" value="1" {{ old('is_release_year_only', $artist->is_release_year_only) ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
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
