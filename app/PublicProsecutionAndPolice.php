<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicProsecutionAndPolice extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'request_id', 'service_id', 'sub_service_id', 'accused_status', 'accused_gender'
    ];

    protected $casts = [
        'request_id' => 'integer',
        'service_id' => 'integer',
        'sub_service_id' => 'integer',
    ];

    public function Service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function SubService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }
}
