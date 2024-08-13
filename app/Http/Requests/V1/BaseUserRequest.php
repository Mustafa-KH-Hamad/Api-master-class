<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    
    public function mappedRequest(): array
    {
        $attributes = [
            'name' => 'data.attributes.name',
            'email' => 'data.attributes.email',
            'is_manager' => 'data.attributes.is_manager',
            'password' => 'data.attributes.password'  

        ];
        $usedAttributes = [] ;
        foreach ($attributes as $key => $value) {
            if($this->has($value)){
                $usedAttributes[$key] = $this->input($value) ;
            }
        }
        return $usedAttributes;
    }
}
