<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    //
    use SoftDeletes;

    protected $appends = ['created_date'];
    protected $casts = [
        'sender_id' => 'integer',
        'action_id' => 'integer',
        'seen' => 'integer',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getTextAttribute($key)
    {
        return trans(notification_trans() . '.' . $this->action);
    }

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
