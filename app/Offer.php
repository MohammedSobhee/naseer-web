<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['request_id', 'service_provider_id', 'status', 'payment_type', 'payment_value', 'details'];

    public function ServiceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    public function Order()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}
