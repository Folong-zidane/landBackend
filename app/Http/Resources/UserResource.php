<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transforme la ressource en un tableau.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'role' => $this->role,
            'lands' => LandResource::collection($this->whenLoaded('lands')),
            'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
            'admin_actions' => AdminActionResource::collection($this->whenLoaded('adminActions')),
        ];
    }
}
