<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    /**
     * Public listing of approved events.
     */
    public function index(Request $request)
    {
        $query = Event::approved();

        // Search by title or organizer
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('organizer_name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter by event type
        if ($request->filled('type')) {
            $query->where('event_type', $request->type);
        }

        // Filter by dynamic status
        if ($request->filled('status')) {
            $now = Carbon::now('Asia/Kolkata');
            match ($request->status) {
                'Upcoming' => $query->where('start_datetime', '>', $now),
                'Live' => $query->where('start_datetime', '<=', $now)
                                ->where('end_datetime', '>=', $now),
                'Expired' => $query->where('end_datetime', '<', $now),
                default => null,
            };
        }

        $events = $query->latest('start_datetime')->paginate(12);
        
        // Get unique cities and types for filters
        $cities = Event::approved()
            ->select('city')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->groupBy(fn($city) => strtolower($city))
            ->map(fn($group) => $group->first()) // Keep first encountered casing
            ->sort();

        $types = Event::approved()->distinct()->pluck('event_type')->filter();

        return view('events.index', compact('events', 'cities', 'types'));
    }

    /**
     * Public detail page for an event.
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        
        // Ensure user can view it (Policy)
        Gate::authorize('view', $event);

        return view('events.show', compact('event'));
    }
}
