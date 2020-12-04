<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestContractField extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['user_id', 'request_id', 'contract_id', 'contract_field_id', 'value'];
}
