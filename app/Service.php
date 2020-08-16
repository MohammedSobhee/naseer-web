<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    //
    use SoftDeletes;

    protected $casts = [
        'service_provider_type_id' => 'integer'
    ];
}