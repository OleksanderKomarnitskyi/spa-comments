<?php

namespace App\Http\Requests\Comment;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'parent_id'=>[
                'nullable',
                'numeric',
                'exists:comments,id'
            ],
            'user_name'=>[
                'required',
                'string',
                'max:255'
            ],
            'user_email' => [
                'required',
                'string',
                'max:255',
                'email',
            ],
            'url' => [
                'nullable',
                'string',
                'max:255',
            ],
            'body' => [
                'required',
                'string',
                'max:1500'
            ]
        ];
    }
}
