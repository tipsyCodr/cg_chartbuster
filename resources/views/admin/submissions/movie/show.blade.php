<x-admin-layout title="Movie Submission #{{ $movieSubmission->id }}">
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Movie Submission <span class="text-blue-500">#{{ $movieSubmission->id }}</span></h2>
                <p class="text-sm text-gray-500 mt-1">Submitted by {{ $movieSubmission->user?->name ?? 'Guest' }} on {{ $movieSubmission->created_at->format('M d, Y H:i') }}</p>
            </div>
            <a href="{{ route('admin.movie-submissions.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-500 uppercase tracking-widest hover:bg-gray-50 transition-all">
                ← Back to List
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm font-medium">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm font-medium">{{ session('error') }}</div>
        @endif

        {{-- Status Badge --}}
        <div class="flex items-center gap-3">
            @php
                $badge = match($movieSubmission->status) {
                    'approved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                    default    => 'bg-yellow-100 text-yellow-800',
                };
            @endphp
            <span class="px-3 py-1 rounded-full text-sm font-bold {{ $badge }}">{{ ucfirst($movieSubmission->status) }}</span>

            @if($movieSubmission->isApproved() && $movieSubmission->movie)
                <a href="{{ route('admin.movies.show', $movieSubmission->movie) }}" class="text-xs text-blue-600 hover:underline font-semibold">
                    → View Production Record (Movie #{{ $movieSubmission->movie->id }})
                </a>
            @endif
        </div>

        {{-- Submission Details --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-sm font-black text-gray-700 dark:text-white uppercase tracking-widest">Submitted Content</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                @foreach([
                    'Title'          => $movieSubmission->title,
                    'Release Date'   => $movieSubmission->release_date?->format('M d, Y'),
                    'Duration'       => $movieSubmission->duration,
                    'Region'         => $movieSubmission->region_id,
                    'CBFC'           => $movieSubmission->cbfc,
                    'Director'       => $movieSubmission->director,
                    'Trailer URL'    => $movieSubmission->trailer_url,
                    'Production House' => $movieSubmission->production_house_id,
                    'CGCB Rating'    => $movieSubmission->cg_chartbusters_ratings,
                ] as $label => $value)
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ $label }}</p>
                        <p class="text-gray-800 dark:text-white font-medium">{{ $value ?? '—' }}</p>
                    </div>
                @endforeach

                <div class="md:col-span-2">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Description</p>
                    <p class="text-gray-800 dark:text-white">{{ $movieSubmission->description ?? '—' }}</p>
                </div>

                @if($movieSubmission->poster_image)
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Poster (Portrait)</p>
                        <img src="{{ asset('storage/' . $movieSubmission->poster_image) }}" alt="Poster" class="w-32 rounded-xl border border-gray-200 shadow-sm">
                    </div>
                @endif

                @if($movieSubmission->poster_image_landscape)
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Poster (Landscape)</p>
                        <img src="{{ asset('storage/' . $movieSubmission->poster_image_landscape) }}" alt="Landscape Poster" class="w-48 rounded-xl border border-gray-200 shadow-sm">
                    </div>
                @endif

                @if($movieSubmission->genre_ids)
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Genre IDs</p>
                        <p class="text-gray-800 dark:text-white">{{ implode(', ', $movieSubmission->genre_ids) }}</p>
                    </div>
                @endif

                @if($movieSubmission->artists_json)
                    <div class="md:col-span-2">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Artists</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($movieSubmission->artists_json as $entry)
                                <span class="px-2 py-1 bg-gray-100 rounded-lg text-xs text-gray-700">
                                    Artist #{{ $entry['artist_id'] }} / Role #{{ $entry['role'] }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Review Notes (history) --}}
        @if($movieSubmission->review_notes)
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 p-6">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Review Notes</p>
                <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $movieSubmission->review_notes }}</p>
            </div>
        @endif

        {{-- Approve / Reject Actions --}}
        @if($movieSubmission->isPending())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Approve --}}
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6">
                    <h4 class="text-sm font-black text-green-800 uppercase tracking-widest mb-4">Approve Submission</h4>
                    <form action="{{ route('admin.movie-submissions.approve', $movieSubmission) }}" method="POST">
                        @csrf
                        <textarea name="review_notes" rows="3" placeholder="Optional approval notes..." class="w-full border border-green-200 rounded-xl p-3 text-sm bg-white focus:ring-2 focus:ring-green-400 outline-none mb-4"></textarea>
                        <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-green-200">
                            ✓ Approve & Publish to Production
                        </button>
                    </form>
                </div>

                {{-- Reject --}}
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                    <h4 class="text-sm font-black text-red-800 uppercase tracking-widest mb-4">Reject Submission</h4>
                    <form action="{{ route('admin.movie-submissions.reject', $movieSubmission) }}" method="POST">
                        @csrf
                        <textarea name="review_notes" rows="3" placeholder="Reason for rejection (shown to user)..." class="w-full border border-red-200 rounded-xl p-3 text-sm bg-white focus:ring-2 focus:ring-red-400 outline-none mb-4"></textarea>
                        <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-red-200">
                            ✕ Reject Submission
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-600">
                This submission has already been <strong>{{ $movieSubmission->status }}</strong>
                @if($movieSubmission->isApproved()) by {{ $movieSubmission->approver?->name }} on {{ $movieSubmission->approved_at?->format('M d, Y') }}. @endif
                @if($movieSubmission->isRejected()) by {{ $movieSubmission->rejecter?->name }} on {{ $movieSubmission->rejected_at?->format('M d, Y') }}. @endif
            </div>
        @endif
    </div>
</x-admin-layout>
