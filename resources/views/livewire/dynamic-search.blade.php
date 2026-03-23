<div>
    <div class="mb-4 flex flex-col gap-2 sm:flex-row">
        <input type="text" wire:model.live="query" placeholder="Search Here..."
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <x-danger-button wire:click="clearSearch" class="w-full justify-center sm:w-auto">Clear</x-danger-button>
    </div>

    <div class="border border-gray-300 rounded-md">
        <div class="p-3 bg-gray-50 border-b">
            <h3 class="font-semibold">
                {{ $isSearching ? "Search Results ({$records->total()} found)" : "All " . Str::plural($model) }}
            </h3>
        </div>

        <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200 whitespace-nowrap">
                            {{ Str::title(str_replace('_', ' ', $column)) }}
                        </th>
                    @endforeach
                    <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200 whitespace-nowrap">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        @foreach ($columns as $column)
                            <td class="px-4 py-4 text-sm bg-white border-b border-gray-200 align-top">
                                @if (Str::contains($column, ['image','photo']))
                                    <img src="{{ Storage::url($record->$column ?? '') }}" alt="" class="object-cover w-16 h-24 rounded">
                                @elseif (in_array($column, ['category', 'category_ids', 'artist_category_ids']))
                                    @php
                                        $ids = is_array($record->$column) ? $record->$column : (is_string($record->$column) ? json_decode($record->$column, true) : []);
                                        $allCats = cache()->remember('artist_categories_all', 3600, function() {
                                            return \App\Models\ArtistCategory::pluck('name', 'id')->toArray();
                                        });
                                    @endphp
                                    @if($ids)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($ids as $id)
                                                @if(isset($allCats[$id]))
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200 shadow-sm">
                                                        {{ $allCats[$id] }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">No category</span>
                                    @endif
                                @else
                                    {{ $record->$column ?? 'N/A' }}
                                @endif
                            </td>
                        @endforeach
                        <td class="px-4 py-4 text-sm bg-white border-b border-gray-200 align-top">
                            <div class="flex space-x-2">
                                @if ($isFrontend)
                                    @php
                                        $routePrefix = strtolower($model);
                                        if ($routePrefix === 'tvshow') {
                                            $routePrefix = 'tv-show';
                                        }
                                    @endphp
                                    <a href="{{ route($routePrefix . '.show', $record->slug) }}"
                                        class="text-blue-600 hover:text-blue-900 whitespace-nowrap">View</a>
                                @else
                                    <a href="{{ route('admin.' . strtolower(Str::plural($model)) . '.edit', $record->id) }}"
                                        class="text-blue-600 hover:text-blue-900 whitespace-nowrap">Edit</a>
                                    <form action="{{ route('admin.' . strtolower(Str::plural($model)) . '.destroy', $record->id) }}"
                                        method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 whitespace-nowrap">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}" class="px-4 py-5 text-center text-gray-500">
                            {{ $isSearching ? "No results for \"$query\"" : "No records available" }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <div class="flex justify-center p-2">
            {{ $records->links() }}
        </div>
    </div>
</div>
