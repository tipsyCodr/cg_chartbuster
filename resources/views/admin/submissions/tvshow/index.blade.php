<x-admin-layout title="TV Show Submissions">
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">TV Show Submissions</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Review and moderate user-submitted TV shows.</p>
            </div>
            <form action="{{ route('admin.tvshow-submissions.index') }}" method="GET">
                <select name="status" onchange="this.form.submit()" class="bg-white border border-gray-300 text-sm rounded-lg p-2.5 text-gray-900">
                    <option value="">All Statuses</option>
                    <option value="pending"  {{ request('status') == 'pending'  ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </form>
        </div>

        @if(session('success')) <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">{{ session('success') }}</div> @endif
        @if(session('error'))   <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">{{ session('error') }}</div>   @endif

        <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3">#</th><th class="px-6 py-3">Title</th><th class="px-6 py-3">Submitted By</th>
                        <th class="px-6 py-3">Status</th><th class="px-6 py-3">Submitted At</th><th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        @php $badge = match($submission->status) { 'approved' => 'bg-green-100 text-green-800', 'rejected' => 'bg-red-100 text-red-800', default => 'bg-yellow-100 text-yellow-800' }; @endphp
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $submission->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 truncate max-w-xs">{{ $submission->title }}</td>
                            <td class="px-6 py-4">{{ $submission->user?->name ?? 'Guest' }}</td>
                            <td class="px-6 py-4"><span class="px-2.5 py-0.5 rounded text-xs font-medium {{ $badge }}">{{ ucfirst($submission->status) }}</span></td>
                            <td class="px-6 py-4">{{ $submission->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4 text-right"><a href="{{ route('admin.tvshow-submissions.show', $submission) }}" class="text-blue-600 hover:text-blue-700 font-bold text-xs uppercase">Review</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No TV show submissions found.</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($submissions->hasPages()) <div class="px-6 py-4 border-t">{{ $submissions->links() }}</div> @endif
        </div>
    </div>
</x-admin-layout>
