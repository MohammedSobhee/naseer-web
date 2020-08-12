<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'idno'=>$this->idno,
            'idno_file'=>$this->idno_file,
            'skill'=>$this->skill,
            'skill_file'=>$this->skill_file,
            'bio'=>$this->bio,
            'address'=>$this->address,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
        ];
    }
}
