<div>
    <div class="flex gap-2 mb-4">
        <input type="text" wire:model.live="query" placeholder="Search Here..."
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <x-danger-button wire:click="clearSearch">Clear</x-danger-button>
    </div>

    <div class="border border-gray-300 rounded-md">
        <div class="p-3 bg-gray-50 border-b">
            <h3 class="font-semibold">
                {{ $isSearching ? "Search Results ({$records->total()} found)" : "All " . Str::plural($model) }}
            </h3>
        </div>

        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                            {{ Str::title(str_replace('_', ' ', $column)) }}
                        </th>
                    @endforeach
                    <th class="px-5 py-3 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        @foreach ($columns as $column)
                            <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                                @if (Str::contains($column, ['image','photo']))
                                    <img src="{{ Storage::url($record->$column ?? '') }}" alt="" class="object-cover w-16 h-24 rounded">
                                @else
                                    {{ $record->$column ?? 'N/A' }}
                                @endif
                            </td>
                        @endforeach
                        <td class="px-5 py-5 text-sm bg-white border-b border-gray-200">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.' . strtolower(Str::plural($model)) . '.edit', $record->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('admin.' . strtolower(Str::plural($model)) . '.destroy', $record->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}" class="px-5 py-5 text-center text-gray-500">
                            {{ $isSearching ? "No results for \"$query\"" : "No records available" }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="flex justify-center p-2">
            {{ $records->links() }}
        </div>
    </div>
</div>
