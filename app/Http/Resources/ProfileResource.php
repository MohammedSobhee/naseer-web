<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'country_code' => $this->country_code,
            'email' => $this->email,
            'verification_code' => $this->verification_code,
            'is_verify' => $this->is_verify,
            'photo' => $this->photo,
            'gender' => $this->gender,
            'type' => $this->type,
            'rate_num' => $this->Rates()->count(),
            'rate' => $this->Rates()->average('rate') ?: 0,
            'is_active' => $this->is_active,
            'service_provider' => new ServiceProviderResource($this->ServiceProvider()->first()),
        ];
    }
}
