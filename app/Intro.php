<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Intro extends Model
{
    //
    use SoftDeletes;

    protected $appends = ['image100', 'image300'];

    public function getImageAttribute($value)
    {
        if (isset($value))
            return url('storage/app/intros/' . $this->id) . '/' . $value;
        return null;
    }


    public function getImage100Attribute()
    {
        if (isset($this->getAttributes()['image']))
            return url('storage/app/intros/' . $this->id) . '/100/' . $this->getAttributes()['image'];
        return null;
    }

    public function getImage300Attribute()
    {
        if (isset($this->getAttributes()['image']))
            return url('storage/app/intros/' . $this->id) . '/300/' . $this->getAttributes()['image'];
        return null;
    }

}
