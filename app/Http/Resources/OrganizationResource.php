<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'founded_at' => $this->founded_at,
            'country_id' => $this->country_id,
            'country' => new CountryResource($this->whenLoaded('country')),
            'description' => $this->description,
            'image' => url('storage/' . $this->image),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
