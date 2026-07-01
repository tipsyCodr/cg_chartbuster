<x-admin-layout title="Movie Submissions">
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Movie Submissions</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Review and moderate user-submitted movies.</p>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('admin.movie-submissions.index') }}" method="GET" class="flex gap-2">
                    <select name="status" onchange="this.form.submit()" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-sm rounded-lg p-2.5 text-gray-900 dark:text-white">
                        <option value="">All Statuses</option>
                        <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium">{{ session('error') }}</div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Title</th>
                            <th class="px-6 py-3">Submitted By</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Submitted At</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                            @php
                                $statusClasses = [
                                    'pending'  => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                ];
                            @endphp
                            <tr class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#{{ $submission->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white truncate max-w-xs">{{ $submission->title }}</td>
                                <td class="px-6 py-4">{{ $submission->user?->name ?? 'Guest' }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded text-xs font-medium {{ $statusClasses[$submission->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $submission->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.movie-submissions.show', $submission) }}"
                                       class="text-blue-600 hover:text-blue-700 font-bold text-xs uppercase tracking-widest">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No movie submissions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($submissions->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
