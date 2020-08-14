<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    //
    use SoftDeletes;

    protected $casts = ['rate' => 'double', 'service_provider_id' => 'integer', 'request_id' => 'integer'];
}
