<?php

namespace App\Http\Requests\Store;

use Illuminate\Foundation\Http\FormRequest;

class Message extends FormRequest
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
            'readed' => ['boolean'],
            'message' => ['required', 'string', "max:255"],
            'recipient_id' => ['required', 'integer'],
        ];
    }
}
