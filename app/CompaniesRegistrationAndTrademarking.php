<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompaniesRegistrationAndTrademarking extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['request_id', 'service_id', 'sub_service_id', 'authorization_type', 'agents_num', 'clients_num', 'debt_value', 'delivery_method', 'property_value'];
    protected $casts = [
        'request_id' => 'integer',
        'service_id' => 'integer',
        'sub_service_id' => 'integer',
        'agents_num' => 'integer',
        'clients_num' => 'integer',
        'debt_value' => 'double',
        'property_value' => 'integer',
    ];
}
