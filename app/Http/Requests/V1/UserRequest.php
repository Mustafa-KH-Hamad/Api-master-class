<?php

namespace App\Http\Requests\V1;

use App\ticketenum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends BaseUserRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rule = [
            'data.attributes.name'=>['required','string'],
            'data.attributes.email'=>['required','email'],
            'data.attributes.is_manager'=>['required','boolean'],
            'data.attributes.password'=>['required',Password::defaults()],
        ];
        
        return $rule;
    }
}
