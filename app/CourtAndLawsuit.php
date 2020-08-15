<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourtAndLawsuit extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'request_id', 'service_id', 'sub_service_id', 'prosecutor_defender', 'lawsuit_nature', 'lawsuit_proof', 'criminal_case', 'country_id', 'court_name', 'property_country',
    ];

    protected $casts = [
        'request_id' => 'integer',
        'service_id' => 'integer',
        'sub_service_id' => 'integer',
        'country_id' => 'integer',
    ];

    protected $appends = ['prosecutor_defender_txt', 'lawsuit_nature_txt', 'lawsuit_proof_txt'];

    public function Country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function Service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function SubService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }

    public function getProsecutorDefenderTxtAttribute()
    {
        if ($this->prosecutor_defender == 'prosecutor')
            return 'مدعي';
        return 'مدعي عليه';
    }

    public function getLawsuitNatureTxtAttribute()
    {
        if ($this->lawsuit_nature == 'individual')
            return 'فرد';
        elseif ($this->lawsuit_nature == 'company_institution')
            return 'شركة/مؤسسة';
        elseif ($this->lawsuit_nature == 'government_agency')
            return 'جهة حكومية';
        return '-';
    }

    public function getLawsuitProofTxtAttribute()
    {
        if ($this->lawsuit_proof == 'lawsuit')
            return 'دعوى';
        elseif ($this->lawsuit_proof == 'proof')
            return 'اثبات';
        return '-';

    }
}
