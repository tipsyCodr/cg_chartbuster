<div x-data="{
    confirmModal: false,
    deleteForm: null,
    deleteName: '',
    openConfirm(formEl, name) {
        this.deleteForm = formEl;
        this.deleteName = name;
        this.confirmModal = true;
    },
    submitDelete() {
        if (this.deleteForm) this.deleteForm.submit();
    }
}">
    <!-- Delete Confirmation Modal -->
    <div x-show="confirmModal" x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" @click="confirmModal = false"></div>
        <!-- Dialog -->
        <div class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full border border-gray-100"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center mb-5 shadow-lg shadow-rose-100">
                    <i class="fas fa-trash-alt text-xl text-rose-500"></i>
                </div>
                <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Delete Record</h3>
                <p class="text-sm text-gray-400 font-bold mt-2 leading-relaxed">
                    Are you sure you want to delete
                    <span class="text-gray-700 font-black" x-text="'&ldquo;' + deleteName + '&rdquo;'"></span>?
                    <br>This action <span class="text-rose-500">cannot be undone</span>.
                </p>
                <div class="flex items-center gap-3 mt-7 w-full">
                    <button @click="confirmModal = false"
                            class="flex-1 py-3 text-xs font-black text-gray-500 uppercase tracking-widest bg-gray-50 hover:bg-gray-100 rounded-2xl transition-all">
                        Cancel
                    </button>
                    <button @click="submitDelete()"
                            class="flex-1 py-3 text-xs font-black text-white uppercase tracking-widest bg-rose-500 hover:bg-rose-600 rounded-2xl transition-all shadow-lg shadow-rose-200 active:scale-95">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Actions -->
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <!-- Search Bar -->
        <div class="relative flex-1 max-w-md">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                <i class="fas fa-search text-sm"></i>
            </span>
            <input type="text" 
                   wire:model.live.debounce.300ms="query" 
                   placeholder="Search {{ Str::plural($model) }}..."
                   class="w-full pl-11 pr-4 py-2.5 bg-white border border-gray-100 rounded-2xl text-sm font-bold text-gray-700 outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500/50 transition-all">
            
            @if($query)
                <button wire:click="clearSearch" class="absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 flex items-center justify-center rounded-lg bg-gray-100 text-gray-400 hover:bg-rose-50 hover:text-rose-500 transition-colors">
                    <i class="fas fa-times text-[10px]"></i>
                </button>
            @endif
        </div>

        <!-- View Toggles & Actions -->
        <div class="flex items-center gap-2">
            <div class="p-1 bg-gray-100 rounded-xl flex items-center">
                <button wire:click="setViewType('table')" 
                        @class([
                            'px-3 py-1.5 rounded-lg text-xs font-black transition-all',
                            'bg-white text-blue-600 shadow-sm' => $viewType === 'table',
                            'text-gray-400 hover:text-gray-600' => $viewType !== 'table'
                        ])>
                    <i class="fas fa-list-ul mr-1.5"></i> TABLE
                </button>
                <button wire:click="setViewType('grid')" 
                        @class([
                            'px-3 py-1.5 rounded-lg text-xs font-black transition-all',
                            'bg-white text-blue-600 shadow-sm' => $viewType === 'grid',
                            'text-gray-400 hover:text-gray-600' => $viewType !== 'grid'
                        ])>
                    <i class="fas fa-th-large mr-1.5"></i> GRID
                </button>
            </div>
            
            @if(!$isFrontend)
                <a href="{{ route('admin.' . strtolower(Str::plural($model)) . '.create') }}" 
                   class="px-5 py-2.5 bg-blue-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition-all transform active:scale-95 flex items-center">
                    <i class="fas fa-plus mr-2"></i> ADD NEW
                </a>
            @endif
        </div>
    </div>

    <!-- Content Area -->
    @if($viewType === 'table')
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <x-admin.table :headers="array_merge($columns, ['actions'])">
                    @forelse($records as $record)
                        <tr class="group hover:bg-gray-50/50 transition-colors">
                            @foreach ($columns as $column)
                                <td class="px-6 py-4">
                                    @if (Str::contains($column, ['image','photo', 'poster']))
                                        <div class="w-12 h-16 rounded-xl overflow-hidden bg-gray-100 border border-gray-50 shadow-sm group-hover:shadow-md transition-all">
                                            <img src="{{ $record->$column ? Storage::url($record->$column) : asset('images/placeholder.png') }}" class="w-full h-full object-cover">
                                        </div>
                                    @elseif (in_array($column, ['category', 'genre', 'region']))
                                        <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-wider">
                                            {{ $record->$column->name ?? 'N/A' }}
                                        </span>
                                    @else
                                        <span class="text-sm font-bold text-gray-600 leading-tight">
                                            {{ $record->$column ?? 'N/A' }}
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                            
                            <!-- Actions Column -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @php
                                        $routePrefix = strtolower(Str::plural($model));
                                        $recordName = $record->title ?? $record->name ?? 'this record';
                                    @endphp
                                    
                                    <a href="{{ route('admin.' . $routePrefix . '.edit', $record->id) }}" 
                                       class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-pencil-alt text-[10px]"></i>
                                    </a>
                                    
                                    <form id="del-{{ $model }}-{{ $record->id }}"
                                          action="{{ route('admin.' . $routePrefix . '.destroy', $record->id) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                @click="openConfirm($el.closest('form'), '{{ addslashes($recordName) }}')"
                                                class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-trash-alt text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + 1 }}" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center text-gray-300 mb-4">
                                        <i class="fas fa-search text-2xl"></i>
                                    </div>
                                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest">No results found</h3>
                                    <p class="text-xs text-gray-400 font-bold mt-1">Try adjusting your search query</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-admin.table>
            </div>
        </div>
    @else
        <!-- Grid View -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
            @forelse($records as $record)
                @php $recordName = $record->title ?? $record->name ?? 'this record'; @endphp
                <div class="group relative bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <!-- Image Wrapper -->
                    @php $imageCol = collect($columns)->first(fn($c) => Str::contains($c, ['image', 'poster', 'photo'])); @endphp
                    <div class="aspect-[2/3] overflow-hidden bg-gray-100">
                        <img src="{{ $record->$imageCol ? Storage::url($record->$imageCol) : asset('images/placeholder.png') }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <!-- Overlay Actions -->
                        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                            <a href="{{ route('admin.' . strtolower(Str::plural($model)) . '.edit', $record->id) }}" 
                               class="w-10 h-10 rounded-xl bg-white text-blue-600 flex items-center justify-center shadow-lg transform hover:scale-110 transition-all">
                                <i class="fas fa-pencil-alt text-sm"></i>
                            </a>
                            <form id="del-grid-{{ $model }}-{{ $record->id }}"
                                  action="{{ route('admin.' . strtolower(Str::plural($model)) . '.destroy', $record->id) }}" 
                                  method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="button"
                                        @click="openConfirm($el.closest('form'), '{{ addslashes($recordName) }}')"
                                        class="w-10 h-10 rounded-xl bg-rose-500 text-white flex items-center justify-center shadow-lg transform hover:scale-110 transition-all">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4">
                        <h4 class="text-xs font-black text-gray-800 uppercase truncate mb-1">{{ $record->title ?? $record->name ?? 'Untitled' }}</h4>
                        <div class="flex items-center justify-between mt-2">
                             <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ $record->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-2xl border border-dashed border-gray-200">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest leading-loose">No {{ Str::plural($model) }} found matching your criteria</p>
                </div>
            @endforelse
        </div>
    @endif

    <!-- Pagination -->
    <div class="mt-8">
        {{ $records->links() }}
    </div>
</div>
