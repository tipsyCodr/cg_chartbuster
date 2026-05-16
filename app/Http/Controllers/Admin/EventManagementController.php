<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Http\Requests\UpdateEventRequest;
use App\Services\EventUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class EventManagementController extends Controller
{
    protected $uploadService;

    public function __construct(EventUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Display a listing of all events for moderation.
     */
    public function index(Request $request)
    {
        Gate::authorize('moderate', Event::class);

        $query = Event::query();

        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(20);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show edit form for an event.
     */
    public function edit(Event $event)
    {
        Gate::authorize('moderate', Event::class);
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update an event (moderation).
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        Gate::authorize('moderate', Event::class);
        
        $validated = $request->validated();

        if ($request->hasFile('poster')) {
            $this->uploadService->deletePoster($event->poster);
            $validated['poster'] = $this->uploadService->uploadPoster($request->file('poster'));
        }

        // Combine date and times if changed
        $start_datetime = Carbon::parse($validated['event_date'] . ' ' . $validated['start_time'], 'Asia/Kolkata');
        $end_datetime = Carbon::parse($validated['event_date'] . ' ' . $validated['end_time'], 'Asia/Kolkata');
        
        $validated['start_datetime'] = $start_datetime;
        $validated['end_datetime'] = $end_datetime;
        
        if ($validated['registration_deadline']) {
            $validated['registration_deadline'] = Carbon::parse($validated['registration_deadline'], 'Asia/Kolkata')->endOfDay();
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Approve an event quickly.
     */
    public function approve(Event $event)
    {
        Gate::authorize('moderate', Event::class);
        $event->update(['approval_status' => 'approved']);
        return back()->with('success', 'Event approved.');
    }

    /**
     * Reject an event quickly.
     */
    public function reject(Event $event)
    {
        Gate::authorize('moderate', Event::class);
        $event->update(['approval_status' => 'rejected']);
        return back()->with('success', 'Event rejected.');
    }

    /**
     * Remove an event.
     */
    public function destroy(Event $event)
    {
        Gate::authorize('moderate', Event::class);
        $this->uploadService->deletePoster($event->poster);
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted.');
    }
}
