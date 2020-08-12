<?php

namespace App\Http\Resources;

use App\Country;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        if ($this->type == 'select') {
            if ($this->data == 'country_id')
                $data = CountryResource::collection(Country::all());
            else {
                $data = collect(json_decode($this->data));
                $data = DataResource::collection($data);
            }
        }

//        if ($this->type == 'select_tree')
//            $data = FieldResource::collection($this->Children()->get());

        return [
            'id' => $this->id,
            'key' => $this->key,
            'value' => $this->value,
            'hint' => $this->hint,
            'type' => $this->type,
            'select_key' => $this->select_key,
            'data' => $data,
            'fields' => FieldResource::collection($this->Children()->get()),
        ];
    }
}
