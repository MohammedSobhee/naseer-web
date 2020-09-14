<?php

namespace App\Http\Resources;

use App\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EstateFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        $order = Request::find($request->get('request_id'));
        $value = 0;
        if ($order->service_id == 5) {
            $annual = $order->AnnualLegalContract()->first();
            $value = $annual->{$this->key};
        } elseif ($order->service_id == 7) {
            $division = $order->DivisionOfInheritance()->first();
            $value = $division->{$this->key};
        }

        return [
            'id' => $this->id,
            'sub_service_id' => $this->sub_service_id,
            'hint' => $this->hint,
            'key' => $this->key,
            'label' => $this->label,
            'value' => $value,
            'type' => $this->type,
        ];
    }
}
