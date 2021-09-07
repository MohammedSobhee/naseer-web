<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    //
    use SoftDeletes;

    protected $casts = [
        'user_id' => 'integer',
        'city_id' => 'integer',
        'service_id' => 'integer',
        'level' => 'integer',
        'contract_status' => 'integer',
        'is_active' => 'boolean',
        'is_edit' => 'boolean',

    ];

    protected $fillable = ['status'];
    protected $appends = ['offers_num'];

    public function getCaseFileAttribute($value)
    {
        if (isset($value))
            return url('assets/upload') . '/' . $value;
    }

    public function getCaseAudioAttribute($value)
    {
        if (isset($value))
            return url('assets/upload') . '/' . $value;
    }

    public function getEvidencesFileAttribute($value)
    {
        if (isset($value))
            return url('assets/upload') . '/' . $value;
    }

    public function getEvidencesAudioAttribute($value)
    {
        if (isset($value))
            return url('assets/upload') . '/' . $value;
    }

    public function getPreferredOutcomesFileAttribute($value)
    {
        if (isset($value))
            return url('assets/upload') . '/' . $value;
    }

    public function getPreferredOutcomesAudioAttribute($value)
    {
        if (isset($value))
            return url('assets/upload') . '/' . $value;
    }

    public function City()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function Offers()
    {
        return $this->hasMany(Offer::class, 'request_id', 'id');
    }

    public function CourtAndLawsuit()
    {
        return $this->hasOne(CourtAndLawsuit::class, 'request_id', 'id');
    }

    public function PublicProsecutionAndPolice()
    {
        return $this->hasOne(PublicProsecutionAndPolice::class, 'request_id', 'id');
    }

    public function AnnualLegalContract()
    {
        return $this->hasOne(AnnualLegalContract::class, 'request_id', 'id');
    }

    public function Arbitration()
    {
        return $this->hasOne(Arbitration::class, 'request_id', 'id');
    }

    public function AssignExpert()
    {
        return $this->hasOne(AssignExpert::class, 'request_id', 'id');
    }

    public function CompaniesRegistrationAndTrademarking()
    {
        return $this->hasOne(CompaniesRegistrationAndTrademarking::class, 'request_id', 'id');
    }

    public function DivisionOfInheritance()
    {
        return $this->hasOne(DivisionOfInheritance::class, 'request_id', 'id');
    }

    public function DraftingRegulationAndContract()
    {
        return $this->hasOne(DraftingRegulationAndContract::class, 'request_id', 'id');
    }

    public function MarriageOfficer()
    {
        return $this->hasOne(MarriageOfficer::class, 'request_id', 'id');
    }

    public function WitnessRequest()
    {
        return $this->hasOne(WitnessRequest::class, 'request_id', 'id');
    }

    public function getOffersNumAttribute()
    {
        return $this->Offers()->count();
    }
}
