<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubService extends Model
{
    //
    use SoftDeletes;

    protected $casts = ['service_id' => 'integer', 'is_case' => 'boolean', 'is_evidence' => 'boolean', 'is_prefered_outcome' => 'boolean'];

    public function Fields()
    {
        return $this->hasMany(RequestField::class, 'sub_service_id', 'id');
    }

    public function getIconAttribute($value)
    {
        if (isset($value))
            return url('assets/service_ic/') . '/' . $value;
        return null;
    }
}
