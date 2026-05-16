<x-admin-layout title="Content Submissions">
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Content Submissions</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Review and moderate user-submitted content.</p>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <form action="{{ route('admin.submissions.index') }}" method="GET" class="flex gap-2">
                    <select name="status" onchange="this.form.submit()" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block p-2.5">
                        <option value="">All Statuses</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    
                    <select name="type" onchange="this.form.submit()" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block p-2.5">
                        <option value="">All Types</option>
                        <option value="Movie" {{ request('type') == 'Movie' ? 'selected' : '' }}>Movie</option>
                        <option value="Song" {{ request('type') == 'Song' ? 'selected' : '' }}>Song</option>
                        <option value="TV Show" {{ request('type') == 'TV Show' ? 'selected' : '' }}>TV Show</option>
                        <option value="Artist" {{ request('type') == 'Artist' ? 'selected' : '' }}>Artist</option>
                        <option value="Event" {{ request('type') == 'Event' ? 'selected' : '' }}>Event</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-200 dark:border-gray-600">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3">Title</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Submitted At</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                            <tr class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">#{{ $submission->id }}</td>
                                <td class="px-6 py-4">
                                    {{ $submission->user ? $submission->user->name : 'Guest' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        {{ $submission->content_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 truncate max-w-xs">{{ $submission->title }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClasses = [
                                            'submitted' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                            'under_review' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300',
                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                        ];
                                        $class = $statusClasses[$submission->moderation_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300';
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded text-xs font-medium {{ $class }}">
                                        {{ ucfirst(str_replace('_', ' ', $submission->moderation_status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $submission->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.submissions.show', $submission) }}" class="text-yellow-600 hover:text-yellow-700 dark:text-yellow-500 dark:hover:text-yellow-400 font-bold">Review</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No submissions found.</td>
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
