<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Services\EventUploadService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EventSubmissionController extends Controller
{
    protected $uploadService;

    public function __construct(EventUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Show the event submission form.
     */
    public function create()
    {
        return view('events.submit');
    }

    /**
     * Handle the event submission.
     */
    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();

        // Combine date and times
        $start_datetime = Carbon::parse($validated['event_date'] . ' ' . $validated['start_time'], 'Asia/Kolkata');
        $end_datetime = Carbon::parse($validated['event_date'] . ' ' . $validated['end_time'], 'Asia/Kolkata');
        
        $registration_deadline = $validated['registration_deadline'] 
            ? Carbon::parse($validated['registration_deadline'], 'Asia/Kolkata')->endOfDay()
            : null;

        // Handle File Upload
        $posterPath = $this->uploadService->uploadPoster($request->file('poster'));

        $event = Event::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'event_type' => $validated['event_type'],
            'event_mode' => $validated['event_mode'],
            'venue' => $validated['venue'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'organizer_name' => $validated['organizer_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'] ?? null,
            'description' => $validated['description'],
            'registration_link' => $validated['registration_link'] ?? null,
            'entry_fee' => $validated['entry_fee'],
            'poster' => $posterPath,
            'start_datetime' => $start_datetime,
            'end_datetime' => $end_datetime,
            'registration_deadline' => $registration_deadline,
            'approval_status' => 'pending',
        ]);

        return redirect()->route('events.show', $event->slug)
            ->with('success', 'Event submitted successfully! It will be visible once approved by admin.');
    }
}
