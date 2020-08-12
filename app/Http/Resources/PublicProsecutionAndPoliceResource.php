<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicProsecutionAndPoliceResource extends JsonResource
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
            'service_id' => $this->service_id,
            'sub_service_id' => $this->sub_service_id,
            'accused_status' => $this->accused_status,
            'accused_gender' => $this->accused_gender,
            'service' => new ServiceResource($this->Service()->first()),
            'sub_service' => new SubServiceTwoResource($this->SubService()->first()),
        ];
    }
}
