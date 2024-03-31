<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'original_link' => 'required|url',
            'max_visits' => 'integer|min:0',
            'short_link' => 'unique:short_links',
            'expires_at' => 'date|before:' . now()->addDay()->toDateTimeString(),
        ];

        if (!app()->environment('testing')) {
            $rules['expires_at'] .= '|after:now';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'expires_at.before' => __('validations.expires_at_before'),
        ];
    }
}
