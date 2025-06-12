<?php

namespace AdevPmftc\NovaArtisanCards\DatabaseSeed\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatabaseSeedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'seederClass' => ['required', 'string', 'max:255']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
