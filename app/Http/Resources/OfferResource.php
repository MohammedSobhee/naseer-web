<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'status' => $this->status,
            'payment_type' => $this->payment_type,
            'payment_value' => $this->payment_value,
            'details' => $this->details,
            'service_provider' => new ProfileResource($this->ServiceProvider()->first()),
            'order' => new OrderSecondResource($this->Order()->first()),

        ];
    }
}
