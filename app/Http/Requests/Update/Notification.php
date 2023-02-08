<?php

namespace App\Http\Requests\Update;

use App\Rules\StringValid;
use Illuminate\Foundation\Http\FormRequest;

class Notification extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'message' => ['required', new StringValid(), 'max:255']
        ];
    }
}
