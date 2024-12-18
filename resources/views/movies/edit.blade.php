<x-details-layout class="space-y-6">
    <h1 class="font-bold">Edit Movie Details</h1>

    <form action="{{ route('movies.store') }}" method="post" enctype="multipart/form-data"
        class="mt-6 space-y-8 divide-y divide-gray-200">
        @csrf
        <div class="flex justify-evenly">
            <div class="space-y-6 sm:space-y-5">
                <div class="sm:grid sm:grid-cols-1 sm:gap-4 sm:items-start sm:pt-5">
                    <label for="title"
                        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Title
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="p-2  border block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <label for="description"
                        class="block p-2 text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Description
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <textarea name="description" id="description" rows="3"
                            class="p-2  border block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div>
                    <label for="release_date"
                        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Release Date
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="date" name="release_date" id="release_date" value="{{ old('release_date') }}"
                            class="p-2  border block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div class="pt-5 ">
                    <div class="flex justify-start">
                        <button type="submit"
                            class=" w-full inline-flex justify-center py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create
                        </button>
                    </div>
                </div>
            </div>

            <div class="space-y-6 sm:space-y-5">
                <div class="sm:grid sm:grid-cols-1 sm:gap-4 sm:items-start sm:pt-5">
                    <label for="duration"
                        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Duration
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="number" name="duration" id="duration" value="{{ old('duration') }}"
                            class="p-2  border block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <label for="genre"
                        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Genre
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="text" name="genre" id="genre" value="{{ old('genre') }}"
                            class="p-2  border block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <label for="director"
                        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Director
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="text" name="director" id="director" value="{{ old('director') }}"
                            class="p-2  border block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <label for="poster_image"
                        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Poster Image
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="file" name="poster_image" id="poster_image" accept="image/*"
                            class="block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <label for="trailer_url"
                        class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Trailer URL
                    </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">
                        <input type="url" name="trailer_url" id="trailer_url" value="{{ old('trailer_url') }}"
                            class="p-2  border block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
            </div>
        </div>


    </form>
</x-details-layout>
