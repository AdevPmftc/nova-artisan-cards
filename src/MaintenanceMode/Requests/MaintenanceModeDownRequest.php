<?php

namespace AdevPmftc\NovaArtisanCards\MaintenanceMode\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceModeDownRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'secret' => ['required', 'string', 'max:32']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
