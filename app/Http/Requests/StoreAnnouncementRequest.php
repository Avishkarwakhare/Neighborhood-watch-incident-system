<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'body' => 'required|string|min:10',
            'priority' => 'required|in:normal,urgent,emergency',
            'expires_at' => 'nullable|date|after:now',
        ];
    }
}
