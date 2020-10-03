<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferSecondResource extends JsonResource
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
            'request_id' => $this->request_id,
            'status' => $this->status,
            'down_payment' => $this->down_payment,
            'late_payment' => $this->late_payment,
            'details' => $this->details,
            'service_provider' => new ProfileResource($this->ServiceProvider()->first()),
        ];
    }
}
