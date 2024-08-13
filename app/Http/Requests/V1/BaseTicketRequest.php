<?php

namespace App\Http\Requests\V1;

use App\ticketenum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseTicketRequest extends FormRequest
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
            'title' => 'data.attributes.title',
            'status' => 'data.attributes.status',
            'discription' => 'data.attributes.discription',
            'user_id' => 'data.relationships.author.data.id'  

        ];
        $usedAttributes = [] ;
        foreach ($attributes as $key => $value) {
            if($this->has($value)){
                $usedAttributes[$key] = $this->input($value) ;
            }
        }
        return $usedAttributes;
    }
    public function messages(){
        return [
            'data.attributes.status' => 'invaild data.attributes.status 
            the status must be one of the [A,C,H,X]'
        ];
    }
}
