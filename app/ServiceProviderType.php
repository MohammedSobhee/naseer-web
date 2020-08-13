<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProviderType extends Model
{
    //
    use SoftDeletes;

    public function Services()
    {
        return $this->hasMany(Service::class, 'service_provider_type_id', 'id');
    }
}
