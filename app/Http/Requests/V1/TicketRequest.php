<?php

namespace App\Http\Requests\V1;

use App\ticketenum;
use Illuminate\Validation\Rule;

class TicketRequest extends BaseTicketRequest
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
            'data.attributes.title'=>['required','string'],
            'data.attributes.status'=>['required',Rule::in([ticketenum::ACTIVE,ticketenum::CANCEL,ticketenum::HOLDING,ticketenum::COMPLETE])],
            'data.attributes.discription'=>['required','string'],
        ];
        
        

        if ($this->routeIs('V1ticket.store')){
            
            $rule['data.relationships.author.data.id'] = 'required';
        }
        return $rule;
    }
}
