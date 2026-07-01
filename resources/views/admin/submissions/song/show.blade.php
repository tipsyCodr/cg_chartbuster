<x-admin-layout title="Song Submission #{{ $songSubmission->id }}">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Song Submission <span class="text-blue-500">#{{ $songSubmission->id }}</span></h2>
                <p class="text-sm text-gray-500 mt-1">Submitted by {{ $songSubmission->user?->name ?? 'Guest' }} on {{ $songSubmission->created_at->format('M d, Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.song-submissions.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-500 uppercase tracking-widest hover:bg-gray-50">← Back</a>
        </div>

        @if(session('success')) <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">{{ session('success') }}</div> @endif
        @if(session('error'))   <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">{{ session('error') }}</div>   @endif

        @php $badge = match($songSubmission->status) { 'approved' => 'bg-green-100 text-green-800', 'rejected' => 'bg-red-100 text-red-800', default => 'bg-yellow-100 text-yellow-800' }; @endphp
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-sm font-bold {{ $badge }}">{{ ucfirst($songSubmission->status) }}</span>
            @if($songSubmission->isApproved() && $songSubmission->song)
                <a href="{{ route('admin.songs.edit', $songSubmission->song) }}" class="text-xs text-blue-600 hover:underline font-semibold">→ View Production Record</a>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100"><h3 class="text-sm font-black text-gray-700 uppercase tracking-widest">Submitted Content</h3></div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @foreach(['Title' => $songSubmission->title, 'Album' => $songSubmission->album, 'Release Date' => $songSubmission->release_date?->format('M d, Y'), 'Duration' => $songSubmission->duration, 'Region' => $songSubmission->region_id, 'CGCB Rating' => $songSubmission->cg_chartbusters_ratings, 'Trailer URL' => $songSubmission->trailer_url] as $label => $value)
                    <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $label }}</p><p class="text-gray-800 font-medium">{{ $value ?? '—' }}</p></div>
                @endforeach
                <div class="md:col-span-2"><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Description</p><p class="text-gray-800">{{ $songSubmission->description ?? '—' }}</p></div>
                @if($songSubmission->poster_image)
                    <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Poster</p><img src="{{ asset('storage/' . $songSubmission->poster_image) }}" class="w-32 rounded-xl border border-gray-200"></div>
                @endif
                @if($songSubmission->genre_ids)
                    <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Genre IDs</p><p class="text-gray-800">{{ implode(', ', $songSubmission->genre_ids) }}</p></div>
                @endif
                @if($songSubmission->artists_json)
                    <div class="md:col-span-2"><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Artists</p>
                        <div class="flex flex-wrap gap-2">@foreach($songSubmission->artists_json as $e)<span class="px-2 py-1 bg-gray-100 rounded-lg text-xs">Artist #{{ $e['artist_id'] }} / Role #{{ $e['role'] }}</span>@endforeach</div>
                    </div>
                @endif
            </div>
        </div>

        @if($songSubmission->review_notes)
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6"><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Review Notes</p><p class="text-gray-700 text-sm">{{ $songSubmission->review_notes }}</p></div>
        @endif

        @if($songSubmission->isPending())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6">
                    <h4 class="text-sm font-black text-green-800 uppercase tracking-widest mb-4">Approve Submission</h4>
                    <form action="{{ route('admin.song-submissions.approve', $songSubmission) }}" method="POST">
                        @csrf
                        <textarea name="review_notes" rows="3" placeholder="Optional approval notes..." class="w-full border border-green-200 rounded-xl p-3 text-sm bg-white outline-none mb-4"></textarea>
                        <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all">✓ Approve & Publish</button>
                    </form>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                    <h4 class="text-sm font-black text-red-800 uppercase tracking-widest mb-4">Reject Submission</h4>
                    <form action="{{ route('admin.song-submissions.reject', $songSubmission) }}" method="POST">
                        @csrf
                        <textarea name="review_notes" rows="3" placeholder="Reason for rejection..." class="w-full border border-red-200 rounded-xl p-3 text-sm bg-white outline-none mb-4"></textarea>
                        <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all">✕ Reject</button>
                    </form>
                </div>
            </div>
        @else
            <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-600">
                This submission has already been <strong>{{ $songSubmission->status }}</strong>.
            </div>
        @endif
    </div>
</x-admin-layout>
