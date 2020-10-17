<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    //
    use SoftDeletes;

    protected $appends = ['created_date', 'text'];
    protected $casts = [
        'sender_id' => 'integer',
        'action_id' => 'integer',
        'seen' => 'integer',
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    function Sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function getTextAttribute()
    {
        if ($this->action == 'public')
            return $this->message;
        return __(notification_trans() . '.' . $this->action);
    }

    public function getCreatedDateAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
