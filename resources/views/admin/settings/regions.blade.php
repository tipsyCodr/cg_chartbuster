@extends('layouts.admin')

@section('page-title', 'Regions')

@section('content')
    <div x-data="{ 
        showModal: {{ $errors->any() ? 'true' : 'false' }}, 
        editMode: {{ old('edit_mode') ? 'true' : 'false' }}, 
        regionId: '{{ old('region_id') }}', 
        regionName: '{{ old('name') }}' 
    }" class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Region Management</h1>
            <button @click="showModal = true; editMode = false; regionName = ''; regionId = ''"
                class="px-4 py-2 text-white transition rounded bg-accent hover:bg-accent-dark">
                Add New Region
            </button>
        </div>

        @if (session('success'))
            <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden bg-white rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-xs font-medium text-right text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($regions as $region)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $region->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $region->name }}</td>
                            <td class="px-6 py-4 text-right whitespace-nowrap text-sm font-medium">
                                <button @click="showModal = true; editMode = true; regionId = '{{ $region->id }}'; regionName = '{{ $region->name }}'"
                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    Edit
                                </button>
                                <form action="{{ route('admin.regions.destroy', $region->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this region?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No regions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div x-show="showModal" x-cloak
            class="fixed inset-0 z-50 flex items-start justify-center overflow-x-hidden overflow-y-auto outline-none focus:outline-none py-10">
            <div class="relative w-full max-w-lg mx-auto">
                <div x-show="showModal" @click.away="showModal = false"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="relative flex flex-col w-full bg-white border-0 rounded-lg shadow-xl outline-none focus:outline-none">

                    <!-- Modal Header -->
                    <div class="flex items-start justify-between p-5 border-b border-solid rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold" x-text="editMode ? 'Edit Region' : 'Add New Region'"></h3>
                        <button @click="showModal = false"
                            class="p-1 ml-auto bg-transparent border-0 text-gray-400 float-right text-3xl leading-none font-semibold outline-none focus:outline-none hover:text-gray-600">
                            <span>×</span>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form :action="editMode ? `/admin/regions/${regionId}` : '{{ route('admin.regions.store') }}'" method="POST" class="p-6">
                        @csrf
                        <template x-if="editMode">
                            @method('PUT')
                        </template>
                        
                        <input type="hidden" name="region_id" x-model="regionId">
                        <input type="hidden" name="edit_mode" x-model="editMode">

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Region Name</label>
                            <input type="text" name="name" id="name" x-model="regionName" required autofocus
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <button type="button" @click="showModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-accent rounded-md shadow-sm hover:bg-accent-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span x-text="editMode ? 'Update Region' : 'Save Region'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity -z-10 backdrop-blur-sm" @click="showModal = false"></div>
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