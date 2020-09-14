<?php

namespace App\Http\Resources;

use App\Estate;
use Illuminate\Http\Resources\Json\JsonResource;

class SubServiceEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $extend_data = [
            'hint' => ($this->service_id == 7) ? 'موجودات التركة' : 'حدد أنواع الخدمات السنوية',
            'fields' => EstateFieldResource::collection(Estate::where('sub_service_id', $this->id)->get()),
        ];

        $request->request->add(['is_selected' => ($this->id == $request->get('sub_service_id'))]);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_case' => $this->is_case,
            'is_evidence' => $this->is_evidence,
            'is_preferred_outcome' => $this->is_prefered_outcome,
            'service_id' => $this->service_id,
            'icon' => $this->icon,
            'is_selected' => $this->id == $request->get('sub_service_id'),
            'fields' => FieldEditResource::collection($this->Fields()->whereNull('request_fields.parent_id')->get())->toArray($request),
            'extend_data' => ($this->service_id == 7 || $this->service_id == 5) ? (count($extend_data['fields']) > 0 ? $extend_data : null) : empObj()
        ];
    }
}
