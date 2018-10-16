<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubOrganizationResource extends JsonResource
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
            'slug'=>$this->slug,
            'founded_at' => $this->founded_at,
            'description' => $this->description,
            'country_id' => $this->country_id,
            'country' => new CountryResource($this->whenLoaded('country')),
            'organization_id' => $this->organization_id,
            'organization' => new OrganizationResource($this->whenLoaded('organization'))
        ];
    }
}
