<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estate extends Model
{
    //
    use SoftDeletes;

    protected $casts = ['sub_service_id' => 'integer'];
}
