<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DraftingRegulationAndContract extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['request_id', 'service_id', 'sub_service_id', 'type_service_provided'];

    protected $casts = [
        'request_id' => 'integer',
        'service_id' => 'integer',
        'sub_service_id' => 'integer',
    ];
}
