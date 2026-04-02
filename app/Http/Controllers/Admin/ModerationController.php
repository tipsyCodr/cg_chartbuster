<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Report;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    public function approveReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update([
            'flagged' => 0,
            'removed' => 0,
            'banned' => 0
        ]);

        return response()->json(['success' => true, 'message' => 'Review approved successfully.']);
    }

    public function rejectReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update([
            'removed' => 1,
            'flagged' => 0
        ]);

        return response()->json(['success' => true, 'message' => 'Review rejected (marked as removed).']);
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['success' => true, 'message' => 'Review deleted permanently.']);
    }

    public function updateReportStatus(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->update([
            'status' => $request->status // resolved, rejected, etc.
        ]);

        return response()->json(['success' => true, 'message' => 'Report status updated to ' . $request->status]);
    }
}
