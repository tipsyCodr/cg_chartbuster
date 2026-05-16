<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentSubmission;
use App\Services\SubmissionApprovalService;
use Illuminate\Http\Request;

class ContentModerationController extends Controller
{
    protected $approvalService;

    public function __construct(SubmissionApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }

    public function index(Request $request)
    {
        $query = ContentSubmission::with('user')->latest();

        if ($request->has('status')) {
            $query->where('moderation_status', $request->status);
        }

        if ($request->has('type')) {
            $query->where('content_type', $request->type);
        }

        $submissions = $query->paginate(15);

        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(ContentSubmission $submission)
    {
        return view('admin.submissions.show', compact('submission'));
    }

    public function approve(Request $request, ContentSubmission $submission)
    {
        $this->approvalService->approve($submission, $request->only('admin_notes'));

        return redirect()->route('admin.submissions.index')->with('success', 'Content approved and moved to live tables.');
    }

    public function reject(Request $request, ContentSubmission $submission)
    {
        $this->approvalService->reject($submission, $request->only('admin_notes'));

        return redirect()->route('admin.submissions.index')->with('success', 'Content rejected.');
    }
}
