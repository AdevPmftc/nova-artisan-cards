<?php

namespace AdevPmftc\NovaArtisanCards\HorizonClear\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HorizonClearRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'queue' => ['required', 'string', 'max:255']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
