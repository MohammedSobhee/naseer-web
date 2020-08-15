<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignExpert extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['request_id', 'service_id', 'sub_service_id', 'request_side'];
    protected $casts = [
        'request_id' => 'integer',
        'service_id' => 'integer',
        'sub_service_id' => 'integer',
    ];
    protected $appends = ['request_side_txt'];

    public function Service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function SubService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }

    public function getRequestSideTxtAttribute()
    {
        if ($this->request_side == 'personal_agency')
            return 'جهة شخصية';
        if ($this->request_side == 'judicial_authority')
            return 'جهة قضائية';
    }

}
