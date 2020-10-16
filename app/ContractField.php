<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractField extends Model
{
    //
    use SoftDeletes;

    public function Contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }
}
