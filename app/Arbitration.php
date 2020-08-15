<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arbitration extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['request_id', 'service_id', 'sub_service_id', 'subject', 'value', 'specialty'];
    protected $casts = [
        'request_id' => 'integer',
        'service_id' => 'integer',
        'sub_service_id' => 'integer',
        'value' => 'double',
    ];

    protected $appends = ['specialty_txt'];

    public function Service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function SubService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }

    public function getSpecialtyTxtAttribute()
    {
        //'lawful','legal','engineering','accounting','real_estate','medical','without_specifying'
        if ($this->specialty == 'lawful')
            return 'شرعي';
        if ($this->specialty == 'legal')
            return 'قانوني';
        if ($this->specialty == 'engineering')
            return 'هندسي';
        if ($this->specialty == 'accounting')
            return 'محاسبي';
        if ($this->specialty == 'real_estate')
            return 'عقاري';
        if ($this->specialty == 'medical')
            return 'طبي';
        if ($this->specialty == 'without_specifying')
            return 'بدون تحديد';
    }
}
