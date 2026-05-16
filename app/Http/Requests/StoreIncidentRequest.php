<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorize handled in controller/policy
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'description' => 'required|string|min:20|max:2000',
            'category' => 'required|in:theft,fire,accident,suspicious_activity,vandalism,medical,natural_disaster,other',
            'severity' => 'required|in:low,medium,high,critical',
            'location_address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_anonymous' => 'nullable|boolean',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,pdf|max:10240',
        ];
    }
}
