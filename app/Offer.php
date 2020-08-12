<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    //
    use SoftDeletes;

    public function ServiceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }
}
