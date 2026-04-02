@extends('layouts.admin')

@section('page-title', 'User Registry')

@section('content')
<div x-data="userManagement()" class="space-y-8 pb-20">

    <!-- Header Actions -->
    <x-admin.card>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-xl font-black text-gray-800 tracking-tight">Active User Directory</h2>
                <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">Manage platform access and permissions</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <x-admin.button variant="secondary" icon="fas fa-file-export" href="{{ route('admin.users.export', request()->all()) }}" as="a">
                    Export Data
                </x-admin.button>
                <x-admin.button variant="primary" icon="fas fa-user-plus" @click="isAddModalOpen = true">
                    Provision User
                </x-admin.button>
            </div>
        </div>
    </x-admin.card>

    <!-- Filters & Bulk Actions -->
    <x-admin.card>
        <div class="space-y-6">
            <!-- Filter Bar -->
            <form action="{{ route('admin.user-management') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center gap-4">
                <div class="relative flex-1">
                    <span class="absolute left-4 top-3 text-gray-400">
                        <i class="fas fa-search text-sm"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by identity or communication channel..." 
                           class="w-full pl-11 pr-4 py-2.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-300">
                </div>
                
                <div class="flex flex-wrap items-center gap-3">
                    <select name="role" onchange="this.form.submit()" 
                            class="px-4 py-2.5 bg-gray-50 border-none rounded-xl text-xs font-black uppercase tracking-widest text-gray-500 focus:ring-2 focus:ring-blue-500/20">
                        <option value="">All Designations</option>
                        <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="User" {{ request('role') == 'User' ? 'selected' : '' }}>Standard User</option>
                        <option value="Moderator" {{ request('role') == 'Moderator' ? 'selected' : '' }}>Moderator</option>
                    </select>

                    <select name="status" onchange="this.form.submit()" 
                            class="px-4 py-2.5 bg-gray-50 border-none rounded-xl text-xs font-black uppercase tracking-widest text-gray-500 focus:ring-2 focus:ring-blue-500/20">
                        <option value="">All Status States</option>
                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Authorized</option>
                        <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Restricted</option>
                    </select>

                    @if(request()->anyFilled(['search', 'role', 'status']))
                        <x-admin.button variant="ghost" size="xs" href="{{ route('admin.user-management') }}" as="a">
                            Reset Intelligence
                        </x-admin.button>
                    @endif
                </div>
            </form>

            <!-- Bulk Hub -->
            <div x-show="selectedIds.length > 0" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="p-4 bg-blue-600 rounded-2xl flex items-center justify-between shadow-lg shadow-blue-200">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white mr-3">
                        <span class="text-sm font-black" x-text="selectedIds.length"></span>
                    </div>
                    <span class="text-sm font-black text-white tracking-tight">Active entities selected for batch command</span>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="submitBulkAction('activate')" class="px-3 py-1.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Enable</button>
                    <button @click="submitBulkAction('deactivate')" class="px-3 py-1.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Disable</button>
                    <button @click="submitBulkAction('delete')" class="px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-sm">Purge</button>
                </div>
            </div>
        </div>
    </x-admin.card>

    <!-- User Data Table -->
    <x-admin.card>
        <div class="-mx-6 -my-6">
            <x-admin.table :headers="[
                ['label' => '', 'align' => 'center'],
                'Entity Identity',
                'Communication Hub',
                ['label' => 'Engagement', 'align' => 'center'],
                ['label' => 'Designation', 'align' => 'center'],
                ['label' => 'Access State', 'align' => 'center'],
                ['label' => 'Control', 'align' => 'right']
            ]" :hasBorder="false">
                @foreach($users as $user)
                <tr class="group hover:bg-gray-50/50 transition border-b border-gray-50 last:border-0">
                    <td class="px-6 py-5 text-center">
                        <input type="checkbox" value="{{ $user->id }}" x-model="selectedIds" 
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500/20 w-4 h-4 cursor-pointer">
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center">
                            <div class="mr-3 shrink-0">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-sm font-black shadow-lg shadow-blue-100 group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div>
                                <div class="text-sm font-black text-gray-800 leading-tight">{{ $user->name }}</div>
                                <div class="text-[10px] font-bold text-gray-400 mt-0.5">Registry Dt: {{ $user->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-xs font-bold text-gray-500">{{ $user->email }}</span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="inline-flex items-center space-x-3 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100">
                            <div class="text-center group-hover:scale-110 transition-transform">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">Reviews</p>
                                <p class="text-xs font-black text-blue-600">{{ $user->reviews_count }}</p>
                            </div>
                            <div class="w-px h-6 bg-gray-200"></div>
                            <div class="text-center group-hover:scale-110 transition-transform">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">Ratings</p>
                                <p class="text-xs font-black text-indigo-600">{{ $user->ratings_count }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                            $roleColor = match(strtolower($user->role ?? 'user')) {
                                'admin' => 'purple',
                                'moderator' => 'blue',
                                default => 'emerald',
                            };
                        @endphp
                        <span class="bg-{{ $roleColor }}-50 text-{{ $roleColor }}-600 border border-{{ $roleColor }}-100 py-1 px-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm">
                            {{ ucfirst($user->role ?? 'User') }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span @class([
                            'w-2 h-2 rounded-full inline-block mr-1.5',
                            'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' => $user->is_active,
                            'bg-rose-500 shadow-[0_0_8px_rgba(244,63,94,0.5)]' => !$user->is_active,
                        ])></span>
                        <span @class([
                            'text-[10px] font-black uppercase tracking-widest',
                            'text-emerald-600' => $user->is_active,
                            'text-rose-600' => !$user->is_active,
                        ])>
                            {{ $user->is_active ? 'Authorized' : 'Restricted' }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex items-center justify-end space-x-1">
                            <form action="{{ route('admin.toggle-user', $user->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all" title="Shift Access State">
                                    <i class="fas fa-sync-alt text-xs"></i>
                                </button>
                            </form>
                            <button @click="editUser({{ json_encode($user) }})" class="p-2 text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-all" title="Modify Entity Data">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                
                @if($users->isEmpty())
                <tr>
                    <td colspan="7" class="py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-gray-50 flex items-center justify-center text-gray-200 mb-4">
                                <i class="fas fa-search text-2xl"></i>
                            </div>
                            <p class="text-sm font-black text-gray-400 uppercase tracking-widest">No matching entities located.</p>
                        </div>
                    </td>
                </tr>
                @endif
            </x-admin.table>
        </div>
        
        @if($users->hasPages())
        <div class="mt-8">
            {{ $users->links() }}
        </div>
        @endif
    </x-admin.card>

    <!-- Provisioning Modal (Add User) -->
    <div x-show="isAddModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" 
         x-cloak>
        
        <div @click.away="isAddModalOpen = false" 
             class="bg-white w-full max-w-lg rounded-[32px] overflow-hidden shadow-2xl border border-gray-100 transform transition-all">
            
            <div class="p-8 pb-4 flex items-center justify-between">
                <h3 class="text-2xl font-black text-gray-800 tracking-tight">Provision New Entity</h3>
                <button @click="isAddModalOpen = false" class="p-2 hover:bg-gray-100 rounded-2xl text-gray-400 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="p-8 pt-0 space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Identity Name</label>
                        <input type="text" name="name" required placeholder="Full Legal Name"
                               class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Communication Channel (Email)</label>
                    <input type="email" name="email" required placeholder="entity@cgchartbusters.com"
                           class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-300">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Access Credentials (Password)</label>
                    <input type="password" name="password" required placeholder="Minimum 8 complex characters"
                           class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-300">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Functional Designation</label>
                        <select name="role" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 appearance-none">
                            <option value="User">Standard User</option>
                            <option value="Admin">Super Admin</option>
                            <option value="Moderator">System Moderator</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Initial Status</label>
                        <select name="status" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 appearance-none">
                            <option value="Active">Authorized</option>
                            <option value="Inactive">Restricted</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <x-admin.button type="button" variant="secondary" class="flex-1" @click="isAddModalOpen = false">
                        Abort
                    </x-admin.button>
                    <x-admin.button type="submit" variant="primary" class="flex-1">
                        Commit Provisioning
                    </x-admin.button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Entity Modal -->
    <div x-show="isEditModalOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" 
         x-cloak>
        
        <div @click.away="isEditModalOpen = false" 
             class="bg-white w-full max-w-lg rounded-[32px] overflow-hidden shadow-2xl border border-gray-100 transform transition-all">
            
            <div class="p-8 pb-4 flex items-center justify-between border-b border-gray-50">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 tracking-tight">Modify Entity</h3>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Updating ID: <span x-text="editingUser.id" class="text-blue-600 font-black"></span></p>
                </div>
                <button @click="isEditModalOpen = false" class="p-2 hover:bg-gray-100 rounded-2xl text-gray-400 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <form :action="`{{ url('/admin/user-management/update') }}/${editingUser.id}`" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Identity Name</label>
                        <input type="text" name="name" x-model="editingUser.name" required placeholder="Full Legal Name"
                               class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-300">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Communication Channel (Email)</label>
                    <input type="email" name="email" x-model="editingUser.email" required placeholder="entity@cgchartbusters.com"
                           class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-300">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Update Credentials (Optional Password)</label>
                    <input type="password" name="password" placeholder="Leave blank to maintain current"
                           class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 transition-all placeholder:text-gray-300">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Functional Designation</label>
                        <select name="role" x-model="editingUser.role" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 appearance-none">
                            <option value="User">Standard User</option>
                            <option value="Admin">Super Admin</option>
                            <option value="Moderator">System Moderator</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 px-1">Access Status</label>
                        <select name="status" x-model="editingUser.status" class="w-full px-5 py-3.5 bg-gray-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-500/20 appearance-none">
                            <option value="Active">Authorized</option>
                            <option value="Inactive">Restricted</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <x-admin.button type="button" variant="secondary" class="flex-1" @click="isEditModalOpen = false">
                        Abort
                    </x-admin.button>
                    <x-admin.button type="submit" variant="primary" class="flex-1">
                        Commit Changes
                    </x-admin.button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Action Form (Hidden) -->
    <form id="bulk-action-form" action="{{ route('admin.users.bulk-action') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="action" id="bulk-action-input">
        <template x-for="id in selectedIds" :key="id">
            <input type="hidden" name="user_ids[]" :value="id">
        </template>
    </form>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('userManagement', () => ({
            isAddModalOpen: false,
            isEditModalOpen: false,
            selectedIds: [],
            editingUser: {
                id: '',
                name: '',
                email: '',
                role: 'User',
                status: 'Active'
            },
            
            editUser(user) {
                this.editingUser = {
                    id: user.id,
                    name: user.name,
                    email: user.email,
                    role: user.role || 'User',
                    status: user.is_active ? 'Active' : 'Inactive'
                };
                this.isEditModalOpen = true;
            },

            submitBulkAction(action) {
                if (action === 'delete' && !confirm('IRREVERSIBLE COMMAND: Are you certain you wish to purge the selected entities from the collective database?')) {
                    return;
                }

                document.getElementById('bulk-action-input').value = action;
                document.getElementById('bulk-action-form').submit();
            }
        }));
    });
</script>
@endsection
