<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content_type' => 'required|string|in:Movie,Song,TV Show,Artist,Event,Other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'media_file' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mp3|max:10240', // 10MB limit
            'external_link' => 'nullable|url',
            'category' => 'nullable|string',
            'tags' => 'nullable|string',
            'terms_accepted' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'terms_accepted.accepted' => 'Please accept Terms & Conditions to continue',
        ];
    }
}
