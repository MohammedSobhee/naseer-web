<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intro extends Model
{
    //
    use SoftDeletes;

    public function getImageAttribute($value)
    {
        if (isset($value))
            return url('storage/app/intros/' . $this->id) . '/' . $value;
        return null;
    }
}
