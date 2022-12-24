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
//        $rate_num = 0;
//        $rate = 0;
        if ($this->type == 'service_provider') {
            $rate_num = auth()->check() ? (($this->ProviderRates()->where('is_approved', 1)->count()) ? 1 : 0) : 0;
            $rate = auth()->check() ? (($this->ProviderRates()->where('is_approved', 1)->average('rate')) ?: 0) : 0;
        } else {
            $rate_num = auth()->check() ? (($this->Rates()->where('is_approved', 1)->count()) ? 1 : 0) : 0;
            $rate = auth()->check() ? (($this->Rates()->where('is_approved', 1)->average('rate')) ?: 0) : 0;

        }
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
            'rate_num' => $rate_num,
            'rate' => $rate,
            'is_active' => $this->is_active,
            'is_completed' => $this->is_completed,
            'is_edit' => $this->is_edit,
            'approved_at' => $this->approved_at,
            'city' => new CityResource($this->City()->first()),
            'provider_det' => new ServiceProviderResource($this->ServiceProvider()->first()),
        ];
    }
}
