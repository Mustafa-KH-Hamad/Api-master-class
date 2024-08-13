<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'user',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'manager' => $this->is_manager,
                $this->mergeWhen($request->routeIs('author.*'), [
                    'emailVerifiedAt' => $this->email_verified_at,
                    'createdAt' => $this->created_at,
                    'udpatedAt' => $this->updated_at,
                ])
            ],
            'includes' => ticketResource::collection($this->whenLoaded('tickets')),
            'links' => [
                'self' => route('V1author.show', ['author' => $this->id])
            ]
        ];
    }
}
