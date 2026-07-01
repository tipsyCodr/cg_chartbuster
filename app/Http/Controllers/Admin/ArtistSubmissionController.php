<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtistSubmission;
use App\Services\Submissions\ArtistSubmissionService;
use Illuminate\Http\Request;

class ArtistSubmissionController extends Controller
{
    public function __construct(protected ArtistSubmissionService $service) {}

    public function index(Request $request)
    {
        $query = ArtistSubmission::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->paginate(15)->withQueryString();

        return view('admin.submissions.artist.index', compact('submissions'));
    }

    public function show(ArtistSubmission $artistSubmission)
    {
        $artistSubmission->load(['user', 'approver', 'rejecter', 'artist']);
        return view('admin.submissions.artist.show', compact('artistSubmission'));
    }

    public function approve(Request $request, ArtistSubmission $artistSubmission)
    {
        try {
            $this->service->publish($artistSubmission, $request->input('review_notes'));
            return redirect()->route('admin.artist-submissions.index')
                ->with('success', 'Artist submission approved and published to production.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Approval failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, ArtistSubmission $artistSubmission)
    {
        $this->service->reject($artistSubmission, $request->input('review_notes'));
        return redirect()->route('admin.artist-submissions.index')
            ->with('success', 'Artist submission rejected.');
    }
}
