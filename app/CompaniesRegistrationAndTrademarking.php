<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompaniesRegistrationAndTrademarking extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['request_id', 'service_id', 'sub_service_id', 'authorization_type', 'agents_num', 'clients_num', 'debt_value', 'delivery_method', 'property_value'];
    protected $casts = [
        'request_id' => 'integer',
        'service_id' => 'integer',
        'sub_service_id' => 'integer',
        'agents_num' => 'integer',
        'clients_num' => 'integer',
        'debt_value' => 'double',
        'property_value' => 'integer',
    ];

    protected $appends = ['authorization_type_txt', 'delivery_method_txt'];


    public function Service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function SubService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }

    public function getAuthorizationTypeTxtAttribute()
    {
        if ($this->authorization_type == 'individual')
            return 'وكالة فردية';
        if ($this->authorization_type == 'institution')
            return 'وكالة مؤسسات او شركات';
    }

    public function getDeliveryMethodTxtAttribute()
    {
        if ($this->delivery_method == 'cash')
            return 'نقدا';
        if ($this->delivery_method == 'transfer')
            return 'حوالة';
        if ($this->delivery_method == 'check')
            return 'شيك';
    }

}
