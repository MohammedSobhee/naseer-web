<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestField extends Model
{
    //
    use SoftDeletes;
    protected $casts = ['sub_service_id' => 'integer'];

    public function Parent()
    {
        return $this->belongsTo(RequestField::class, 'parent_id');
    }

    public function Children()
    {
        return $this->hasMany(RequestField::class, 'parent_id', 'id');
    }
}
