<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'event_type' => ['required', 'string', 'max:100'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'event_mode' => ['required', 'in:Online,Offline,Hybrid'],
            'venue' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'organizer_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'description' => ['required', 'string', 'min:50'],
            'registration_link' => ['nullable', 'url', 'max:255'],
            'entry_fee' => ['required', 'string', 'max:100'],
            'poster' => ['nullable', 'image', 'mimes:jpg,png,webp', 'max:2048', 'dimensions:min_width=640,min_height=360'],
            'registration_deadline' => ['nullable', 'date'],
            'approval_status' => ['sometimes', 'in:pending,approved,rejected'],
        ];
    }
}
