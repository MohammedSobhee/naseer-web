<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DivisionOfInheritance extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['request_id', 'service_id', 'sub_service_id', 'heirs_details', 'type_service_provided', 'agreers', 'against', 'money', 'real_estate', 'bonds_shares', 'companies', 'others'];
    protected $casts = [
        'request_id' => 'integer',
        'service_id' => 'integer',
        'sub_service_id' => 'integer',
    ];
}
