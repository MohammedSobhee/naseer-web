<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    //
    use SoftDeletes;

    protected $casts = ['rate' => 'double', 'user_id' => 'integer', 'service_provider_id' => 'integer', 'request_id' => 'integer'];

    public function Client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ServiceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    public function Order()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}
