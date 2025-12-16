<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoomLiftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'specifications' => ['nullable', 'array'],
            'image' => ['nullable', 'image', 'max:2048'],
            'hourly_rate' => ['required', 'numeric', 'min:0'],
            'daily_rate' => ['required', 'numeric', 'min:0'],
            'monthly_rate' => ['required', 'numeric', 'min:0'],
            'is_available' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'hourly_rate.required' => 'The hourly rate is required.',
            'hourly_rate.numeric' => 'The hourly rate must be a number.',
            'daily_rate.required' => 'The daily rate is required.',
            'daily_rate.numeric' => 'The daily rate must be a number.',
            'monthly_rate.required' => 'The monthly rate is required.',
            'monthly_rate.numeric' => 'The monthly rate must be a number.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];
    }
}
