<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'sender_id' => $this->sender_id,
            'action' => $this->action,
            'action_id' => $this->action_id,
            'text' => $this->text,
            'seen' => $this->seen,
            'created_at' => $this->created_at,
            'created_date' => $this->created_date,
            'sender' => new SimpleProfileResource($this->Sender()->first()),
        ];
    }
}
