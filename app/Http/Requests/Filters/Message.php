<?php

namespace App\Http\Requests\Filters;

use App\Rules\TypeCompariseDate;
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
            'limit' => ['integer'],
            'filters.sender' => ['required', 'integer'],
            'filters.recipient' => ['required', 'integer'],
            'filters.created_at.*.value' => ['required', 'date_format:Y-m-d H:i:s'],
            'filters.created_at.*.type' => [new TypeCompariseDate()],
        ];
    }
}
