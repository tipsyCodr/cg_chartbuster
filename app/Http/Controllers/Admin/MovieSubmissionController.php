<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MovieSubmission;
use App\Services\Submissions\MovieSubmissionService;
use Illuminate\Http\Request;

class MovieSubmissionController extends Controller
{
    public function __construct(protected MovieSubmissionService $service) {}

    public function index(Request $request)
    {
        $query = MovieSubmission::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->paginate(15)->withQueryString();

        return view('admin.submissions.movie.index', compact('submissions'));
    }

    public function show(MovieSubmission $movieSubmission)
    {
        $movieSubmission->load(['user', 'approver', 'rejecter', 'movie']);
        return view('admin.submissions.movie.show', compact('movieSubmission'));
    }

    public function approve(Request $request, MovieSubmission $movieSubmission)
    {
        try {
            $this->service->publish($movieSubmission, $request->input('review_notes'));
            return redirect()->route('admin.movie-submissions.index')
                ->with('success', 'Movie submission approved and published to production.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, MovieSubmission $movieSubmission)
    {
        $this->service->reject($movieSubmission, $request->input('review_notes'));
        return redirect()->route('admin.movie-submissions.index')
            ->with('success', 'Movie submission rejected.');
    }
}
