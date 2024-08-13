<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ticketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    //public static $wrap = 'ticket';
    public function toArray(Request $request): array
    {
        return [
            'type' => 'ticket',
            'id' => $this->id ,
            'attributes'=>[
                'title' => $this->title,
                'discription' => $this->when(
                    $request->routeIs('V1ticket.show'),
                    $this->discription,
                ),
                'status' => $this->status ,
                'created_at' =>$this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationships'=>[
                'author'=>[
                    'data'=> [
                        'type' => 'author',
                        'id' =>$this->user_id,
                    ],
                    'link'=>[//TODO
                        'self' => route('V1author.show',['author' => $this->user_id])
                    ]
                ],
            ],
            'includes' => 
                new UserResource($this->whenLoaded('author'))
            ,
            'links' =>[
                'self' => route('V1ticket.show',['ticket'=>$this->id])
            ]
        ];
    }
}

