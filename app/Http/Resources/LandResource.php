<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LandResource extends JsonResource
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
            'description' => $this->description,
            'location' => $this->location,
            'price' => $this->price,
            'area' => $this->area,
            'is_sold' => $this->is_sold,
            'seller' => new UserResource($this->whenLoaded('seller')),
            'images' => LandImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
