@extends('layouts.admin')

@section('page-title', 'User Management')

@section('content')
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-4 bg-gray-50 border-b border-gray-200 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <h2 class="text-xl font-semibold text-gray-800">User Management</h2>
        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:space-x-3 sm:gap-0">
            <button onclick="document.getElementById('add-user-modal').classList.remove('hidden')" 
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Add User
            </button>
            <a href="{{ route('admin.users.export', request()->all()) }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Export Users
            </a>
        </div>
    </div>

    <!-- Bulk Action Form -->
    <form id="bulk-action-form" action="{{ route('admin.users.bulk-action') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="action" id="bulk-action-input">
        <div id="bulk-ids-container"></div>
    </form>

    <!-- Add User Modal -->
    <div id="add-user-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-900 bg-opacity-50">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900">Add New User</h3>
                    <button onclick="document.getElementById('add-user-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                            <option value="Moderator">Moderator</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('add-user-modal').classList.add('hidden')" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="rounded-md bg-blue-500 px-4 py-2 text-sm font-medium text-white hover:bg-blue-600">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="p-4 sm:p-6">
        <form action="{{ route('admin.user-management') }}" method="GET" class="mb-4 flex flex-col gap-3 lg:flex-row lg:justify-between lg:items-center">
            <div class="relative flex-grow lg:mr-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users by name or email..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row sm:space-x-2 sm:gap-0">
                <select name="role" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="">All Roles</option>
                    <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="User" {{ request('role') == 'User' ? 'selected' : '' }}>User</option>
                    <option value="Moderator" {{ request('role') == 'Moderator' ? 'selected' : '' }}>Moderator</option>
                </select>
                <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @if(request()->anyFilled(['search', 'role', 'status']))
                    <a href="{{ route('admin.user-management') }}" class="text-sm text-blue-500 hover:text-blue-700 flex items-center px-2">Clear</a>
                @endif
            </div>
        </form>

        <div class="mb-4 items-center space-x-2 hidden" id="bulk-actions-container">
            <div class="flex items-center space-x-2">
                <span class="text-sm font-medium text-gray-700"><span id="selected-count">0</span> selected:</span>
                <button onclick="submitBulkAction('activate')" class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded hover:bg-green-200">Activate</button>
                <button onclick="submitBulkAction('deactivate')" class="text-sm bg-yellow-100 text-yellow-700 px-3 py-1 rounded hover:bg-yellow-200">Deactivate</button>
                <button onclick="submitBulkAction('delete')" class="text-sm bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200">Delete</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-[760px] w-full bg-white">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left w-10">
                            <input type="checkbox" id="select-all" class="form-checkbox h-5 w-5 text-blue-600">
                        </th>
                        <th class="py-3 px-6 text-left">User</th>
                        <th class="py-3 px-6 text-left">Email</th>
                        <th class="py-3 px-6 text-center">Insights</th>
                        <th class="py-3 px-6 text-center">Role</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($users as $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-100 transition-colors">
                        <td class="py-3 px-6 text-left">
                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox form-checkbox h-5 w-5 text-blue-600">
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center">
                                <div class="mr-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">Joined: {{ $user->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left">{{ $user->email }}</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-xs font-semibold text-gray-600">Reviews: {{ $user->reviews_count }}</span>
                                <span class="text-xs font-semibold text-gray-600">Ratings: {{ $user->ratings_count }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-center">
                            @php
                                $roleColor = match(strtolower($user->role ?? 'user')) {
                                    'admin' => 'purple',
                                    'moderator' => 'blue',
                                    default => 'gray',
                                };
                            @endphp
                            <span class="bg-{{ $roleColor }}-100 text-{{ $roleColor }}-800 py-1 px-3 rounded-full text-xs font-medium">
                                {{ ucfirst($user->role ?? 'User') }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <span class="{{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} py-1 px-3 rounded-full text-xs font-medium">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-2">
                                <form action="{{ route('admin.toggle-user', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button title="Toggle Status" class="text-{{ $user->is_active ? 'yellow' : 'green' }}-500 hover:text-{{ $user->is_active ? 'yellow' : 'green' }}-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
                                    </button>
                                </form>
                                <button class="text-blue-500 hover:text-blue-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($users->isEmpty())
                    <tr>
                        <td colspan="7" class="py-10 text-center text-gray-500">No users found matching your criteria.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>

<script>
    const selectAll = document.getElementById('select-all');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkActionsContainer = document.getElementById('bulk-actions-container');
    const selectedCountSpan = document.getElementById('selected-count');
    const bulkActionForm = document.getElementById('bulk-action-form');
    const bulkActionInput = document.getElementById('bulk-action-input');
    const bulkIdsContainer = document.getElementById('bulk-ids-container');

    function updateBulkActionsUI() {
        const selectedIds = Array.from(userCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        const count = selectedIds.length;
        selectedCountSpan.textContent = count;
        
        if (count > 0) {
            bulkActionsContainer.classList.remove('hidden');
        } else {
            bulkActionsContainer.classList.add('hidden');
        }
    }

    selectAll.addEventListener('change', function() {
        userCheckboxes.forEach(cb => cb.checked = selectAll.checked);
        updateBulkActionsUI();
    });

    userCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkActionsUI);
    });

    function submitBulkAction(action) {
        if (action === 'delete' && !confirm('Are you sure you want to delete selected users? This action cannot be undone.')) {
            return;
        }

        const selectedIds = Array.from(userCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        bulkActionInput.value = action;
        bulkIdsContainer.innerHTML = '';
        
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'user_ids[]';
            input.value = id;
            bulkIdsContainer.appendChild(input);
        });

        bulkActionForm.submit();
    }
</script>
@endsection
