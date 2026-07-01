<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongSubmission;
use App\Services\Submissions\SongSubmissionService;
use Illuminate\Http\Request;

class SongSubmissionController extends Controller
{
    public function __construct(protected SongSubmissionService $service) {}

    public function index(Request $request)
    {
        $query = SongSubmission::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->paginate(15)->withQueryString();

        return view('admin.submissions.song.index', compact('submissions'));
    }

    public function show(SongSubmission $songSubmission)
    {
        $songSubmission->load(['user', 'approver', 'rejecter', 'song']);
        return view('admin.submissions.song.show', compact('songSubmission'));
    }

    public function approve(Request $request, SongSubmission $songSubmission)
    {
        try {
            $this->service->publish($songSubmission, $request->input('review_notes'));
            return redirect()->route('admin.song-submissions.index')
                ->with('success', 'Song submission approved and published to production.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, SongSubmission $songSubmission)
    {
        $this->service->reject($songSubmission, $request->input('review_notes'));
        return redirect()->route('admin.song-submissions.index')
            ->with('success', 'Song submission rejected.');
    }
}
