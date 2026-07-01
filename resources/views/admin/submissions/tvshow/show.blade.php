<x-admin-layout title="TV Show Submission #{{ $tvShowSubmission->id }}">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">TV Show Submission <span class="text-blue-500">#{{ $tvShowSubmission->id }}</span></h2>
                <p class="text-sm text-gray-500 mt-1">Submitted by {{ $tvShowSubmission->user?->name ?? 'Guest' }} on {{ $tvShowSubmission->created_at->format('M d, Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.tvshow-submissions.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-500 uppercase tracking-widest hover:bg-gray-50">← Back</a>
        </div>

        @if(session('success')) <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">{{ session('success') }}</div> @endif
        @if(session('error'))   <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">{{ session('error') }}</div>   @endif

        @php $badge = match($tvShowSubmission->status) { 'approved' => 'bg-green-100 text-green-800', 'rejected' => 'bg-red-100 text-red-800', default => 'bg-yellow-100 text-yellow-800' }; @endphp
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-sm font-bold {{ $badge }}">{{ ucfirst($tvShowSubmission->status) }}</span>
            @if($tvShowSubmission->isApproved() && $tvShowSubmission->tvShow)
                <a href="{{ route('admin.tvshows.show', $tvShowSubmission->tvShow) }}" class="text-xs text-blue-600 hover:underline font-semibold">→ View Production Record</a>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100"><h3 class="text-sm font-black text-gray-700 uppercase tracking-widest">Submitted Content</h3></div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @foreach(['Title' => $tvShowSubmission->title, 'Release Date' => $tvShowSubmission->release_date?->format('M d, Y'), 'Region' => $tvShowSubmission->region_id, 'CBFC' => $tvShowSubmission->cbfc, 'Director' => $tvShowSubmission->director, 'CGCB Rating' => $tvShowSubmission->cg_chartbusters_ratings, 'Trailer URL' => $tvShowSubmission->trailer_url] as $label => $value)
                    <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $label }}</p><p class="text-gray-800 font-medium">{{ $value ?? '—' }}</p></div>
                @endforeach
                <div class="md:col-span-2"><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Description</p><p class="text-gray-800">{{ $tvShowSubmission->description ?? '—' }}</p></div>
                @if($tvShowSubmission->poster_image)
                    <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Poster</p><img src="{{ asset('storage/' . $tvShowSubmission->poster_image) }}" class="w-32 rounded-xl border border-gray-200"></div>
                @endif
                @if($tvShowSubmission->genre_ids)
                    <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Genre IDs</p><p class="text-gray-800">{{ implode(', ', $tvShowSubmission->genre_ids) }}</p></div>
                @endif
            </div>
        </div>

        @if($tvShowSubmission->review_notes)
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6"><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Review Notes</p><p class="text-sm text-gray-700">{{ $tvShowSubmission->review_notes }}</p></div>
        @endif

        @if($tvShowSubmission->isPending())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6">
                    <h4 class="text-sm font-black text-green-800 uppercase tracking-widest mb-4">Approve</h4>
                    <form action="{{ route('admin.tvshow-submissions.approve', $tvShowSubmission) }}" method="POST">
                        @csrf
                        <textarea name="review_notes" rows="3" placeholder="Optional notes..." class="w-full border border-green-200 rounded-xl p-3 text-sm bg-white outline-none mb-4"></textarea>
                        <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-black uppercase tracking-widest">✓ Approve & Publish</button>
                    </form>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                    <h4 class="text-sm font-black text-red-800 uppercase tracking-widest mb-4">Reject</h4>
                    <form action="{{ route('admin.tvshow-submissions.reject', $tvShowSubmission) }}" method="POST">
                        @csrf
                        <textarea name="review_notes" rows="3" placeholder="Reason for rejection..." class="w-full border border-red-200 rounded-xl p-3 text-sm bg-white outline-none mb-4"></textarea>
                        <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-black uppercase tracking-widest">✕ Reject</button>
                    </form>
                </div>
            </div>
        @else
            <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-600">This submission has already been <strong>{{ $tvShowSubmission->status }}</strong>.</div>
        @endif
    </div>
</x-admin-layout>
