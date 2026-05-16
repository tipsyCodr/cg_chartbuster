<?php

namespace App\Http\Controllers;

use App\Models\ContentSubmission;
use App\Http\Requests\StoreContentSubmissionRequest;
use Illuminate\Support\Facades\Storage;

class ContentSubmissionController extends Controller
{
    public function create()
    {
        return view('submissions.create');
    }

    public function store(StoreContentSubmissionRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('media_file')) {
            $validated['media_file'] = $request->file('media_file')->store('submissions', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['moderation_status'] = 'submitted';
        $validated['terms_accepted'] = $request->has('terms_accepted');

        ContentSubmission::create($validated);

        return redirect()->back()->with('success', 'Your content has been submitted for review. Thank you!');
    }
}
