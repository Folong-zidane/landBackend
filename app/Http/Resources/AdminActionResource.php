<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminActionResource extends JsonResource
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
            'admin' => new UserResource($this->whenLoaded('admin')),
            'action' => $this->action,
            'description' => $this->description,
            'action_date' => $this->action_date,
        ];
    }
}
