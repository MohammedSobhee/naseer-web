<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['text'];

    public function Fields()
    {
        return $this->hasMany(ContractField::class, 'contract_id', 'id');
    }

    public function Services()
    {
        return $this->belongsToMany(Service::class, 'contract_services', 'service_id', 'contract_id', 'id', 'id')->whereNull('contract_services.deleted_at');
    }


}
