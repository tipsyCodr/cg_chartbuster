<x-admin-layout title="Review Submission #{{ $submission->id }}">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.submissions.index') }}" class="text-sm text-yellow-600 hover:text-yellow-700 dark:text-yellow-500 dark:hover:text-yellow-400 flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i> Back to list
                </a>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mt-2">Review Submission #{{ $submission->id }}</h2>
            </div>
            
            <div class="flex gap-2">
                @if($submission->moderation_status !== 'approved')
                    <form action="{{ route('admin.submissions.approve', $submission) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this content? It will be moved to live tables.')">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-colors">
                            Approve & Go Live
                        </button>
                    </form>
                @endif
                
                @if($submission->moderation_status !== 'rejected')
                    <form action="{{ route('admin.submissions.reject', $submission) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this submission?')">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg transition-colors">
                            Reject Submission
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Content Details</h3>
                    
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <span class="text-xs uppercase text-gray-500 dark:text-gray-400 font-bold">Title</span>
                            <p class="text-gray-900 dark:text-white text-lg font-medium">{{ $submission->title }}</p>
                        </div>
                        
                        <div>
                            <span class="text-xs uppercase text-gray-500 dark:text-gray-400 font-bold">Content Type</span>
                            <p class="text-gray-900 dark:text-white">{{ $submission->content_type }}</p>
                        </div>

                        <div>
                            <span class="text-xs uppercase text-gray-500 dark:text-gray-400 font-bold">Description</span>
                            <div class="text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900/50 p-4 rounded-lg mt-1">
                                {!! nl2br(e($submission->description)) !!}
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-xs uppercase text-gray-500 dark:text-gray-400 font-bold">Category</span>
                                <p class="text-gray-900 dark:text-white">{{ $submission->category ?: 'N/A' }}</p>
                            </div>
                            <div>
                                <span class="text-xs uppercase text-gray-500 dark:text-gray-400 font-bold">Tags</span>
                                <p class="text-gray-900 dark:text-white">{{ $submission->tags ?: 'N/A' }}</p>
                            </div>
                        </div>

                        @if($submission->external_link)
                            <div>
                                <span class="text-xs uppercase text-gray-500 dark:text-gray-400 font-bold">External Link</span>
                                <p class="mt-1">
                                    <a href="{{ $submission->external_link }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                                        {{ $submission->external_link }} <i class="fas fa-external-link-alt text-xs"></i>
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Admin Notes -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Moderation Notes</h3>
                    <form action="{{ route('admin.submissions.approve', $submission) }}" id="notes-form" method="POST" class="hidden">@csrf</form>
                    <textarea name="admin_notes" form="notes-form" rows="3" class="w-full bg-gray-50 dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-yellow-500 focus:border-yellow-500" placeholder="Add notes for this submission (optional)...">{{ $submission->admin_notes }}</textarea>
                    <p class="text-xs text-gray-500 mt-2">Notes will be saved upon approval or rejection.</p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Media Preview -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Media Preview</h3>
                    @if($submission->media_file)
                        <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                            @php
                                $extension = pathinfo($submission->media_file, PATHINFO_EXTENSION);
                                $videoExtensions = ['mp4', 'webm', 'ogg'];
                                $audioExtensions = ['mp3', 'wav', 'ogg'];
                            @endphp

                            @if(in_array(strtolower($extension), $videoExtensions))
                                <video controls class="w-full">
                                    <source src="{{ asset('storage/' . $submission->media_file) }}" type="video/{{ $extension }}">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif(in_array(strtolower($extension), $audioExtensions))
                                <audio controls class="w-full">
                                    <source src="{{ asset('storage/' . $submission->media_file) }}" type="audio/{{ $extension }}">
                                    Your browser does not support the audio element.
                                </audio>
                            @else
                                <img src="{{ asset('storage/' . $submission->media_file) }}" alt="Preview" class="w-full h-auto">
                            @endif
                        </div>
                        <div class="mt-4">
                            <a href="{{ asset('storage/' . $submission->media_file) }}" target="_blank" class="text-xs text-yellow-600 font-bold uppercase hover:underline">Download / Open Original</a>
                        </div>
                    @else
                        <div class="bg-gray-100 dark:bg-gray-900 rounded-lg p-8 text-center text-gray-500 italic">
                            No media uploaded.
                        </div>
                    @endif
                </div>

                <!-- Meta Info -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Submission Meta</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Status:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($submission->moderation_status) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Submitted:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $submission->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">User ID:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $submission->user_id ?: 'Guest' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">T&C Accepted:</span>
                            <span class="font-medium {{ $submission->terms_accepted ? 'text-green-500' : 'text-red-500' }}">
                                {{ $submission->terms_accepted ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
