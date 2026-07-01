<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvShowSubmission;
use App\Services\Submissions\TvShowSubmissionService;
use Illuminate\Http\Request;

class TvShowSubmissionController extends Controller
{
    public function __construct(protected TvShowSubmissionService $service) {}

    public function index(Request $request)
    {
        $query = TvShowSubmission::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->paginate(15)->withQueryString();

        return view('admin.submissions.tvshow.index', compact('submissions'));
    }

    public function show(TvShowSubmission $tvShowSubmission)
    {
        $tvShowSubmission->load(['user', 'approver', 'rejecter', 'tvShow']);
        return view('admin.submissions.tvshow.show', compact('tvShowSubmission'));
    }

    public function approve(Request $request, TvShowSubmission $tvShowSubmission)
    {
        try {
            $this->service->publish($tvShowSubmission, $request->input('review_notes'));
            return redirect()->route('admin.tvshow-submissions.index')
                ->with('success', 'TV Show submission approved and published to production.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, TvShowSubmission $tvShowSubmission)
    {
        $this->service->reject($tvShowSubmission, $request->input('review_notes'));
        return redirect()->route('admin.tvshow-submissions.index')
            ->with('success', 'TV Show submission rejected.');
    }
}
