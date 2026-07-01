<x-admin-layout title="Artist Submission #{{ $artistSubmission->id }}">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Artist Submission <span class="text-blue-500">#{{ $artistSubmission->id }}</span></h2>
                <p class="text-sm text-gray-500 mt-1">Submitted by {{ $artistSubmission->user?->name ?? 'Guest' }} on {{ $artistSubmission->created_at->format('M d, Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.artist-submissions.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-500 uppercase tracking-widest hover:bg-gray-50">← Back</a>
        </div>

        @if(session('success')) <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">{{ session('success') }}</div> @endif
        @if(session('error'))   <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">{{ session('error') }}</div>   @endif

        @php $badge = match($artistSubmission->status) { 'approved' => 'bg-green-100 text-green-800', 'rejected' => 'bg-red-100 text-red-800', default => 'bg-yellow-100 text-yellow-800' }; @endphp
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-sm font-bold {{ $badge }}">{{ ucfirst($artistSubmission->status) }}</span>
            @if($artistSubmission->isApproved() && $artistSubmission->artist)
                <a href="{{ route('admin.artists.edit', $artistSubmission->artist) }}" class="text-xs text-blue-600 hover:underline font-semibold">→ View Production Record</a>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100"><h3 class="text-sm font-black text-gray-700 uppercase tracking-widest">Submitted Content</h3></div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @foreach(['Name' => $artistSubmission->name, 'City' => $artistSubmission->city, 'Birth Date' => $artistSubmission->birth_date?->format('M d, Y'), 'CGCB Rating' => $artistSubmission->cgcb_rating, 'Website' => $artistSubmission->website_url, 'YouTube' => $artistSubmission->youtube_url, 'Instagram' => $artistSubmission->instagram_url, 'Facebook' => $artistSubmission->facebook_url, 'Twitter' => $artistSubmission->twitter_url, 'Founded Year' => $artistSubmission->founded_year, 'Active Since' => $artistSubmission->active_since] as $label => $value)
                    <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $label }}</p><p class="text-gray-800 font-medium">{{ $value ?? '—' }}</p></div>
                @endforeach
                <div class="md:col-span-2"><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Bio</p><p class="text-gray-800">{{ $artistSubmission->bio ?? '—' }}</p></div>
                @if($artistSubmission->photo)
                    <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Photo</p><img src="{{ asset('storage/' . $artistSubmission->photo) }}" class="w-24 h-24 rounded-full object-cover border border-gray-200"></div>
                @endif
                @if($artistSubmission->banner_image)
                    <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Banner</p><img src="{{ asset('storage/' . $artistSubmission->banner_image) }}" class="w-48 rounded-xl border border-gray-200"></div>
                @endif
            </div>
        </div>

        @if($artistSubmission->review_notes)
            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6"><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Review Notes</p><p class="text-sm text-gray-700">{{ $artistSubmission->review_notes }}</p></div>
        @endif

        @if($artistSubmission->isPending())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6">
                    <h4 class="text-sm font-black text-green-800 uppercase tracking-widest mb-4">Approve</h4>
                    <form action="{{ route('admin.artist-submissions.approve', $artistSubmission) }}" method="POST">
                        @csrf
                        <textarea name="review_notes" rows="3" placeholder="Optional notes..." class="w-full border border-green-200 rounded-xl p-3 text-sm bg-white outline-none mb-4"></textarea>
                        <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-black uppercase tracking-widest">✓ Approve & Publish</button>
                    </form>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                    <h4 class="text-sm font-black text-red-800 uppercase tracking-widest mb-4">Reject</h4>
                    <form action="{{ route('admin.artist-submissions.reject', $artistSubmission) }}" method="POST">
                        @csrf
                        <textarea name="review_notes" rows="3" placeholder="Reason for rejection..." class="w-full border border-red-200 rounded-xl p-3 text-sm bg-white outline-none mb-4"></textarea>
                        <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-black uppercase tracking-widest">✕ Reject</button>
                    </form>
                </div>
            </div>
        @else
            <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-600">This submission has already been <strong>{{ $artistSubmission->status }}</strong>.</div>
        @endif
    </div>
</x-admin-layout>
