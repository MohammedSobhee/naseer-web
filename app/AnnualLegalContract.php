<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnualLegalContract extends Model
{
    //
    use SoftDeletes;

    protected $fillable = ['request_id', 'service_id', 'sub_service_id', 'activity', 'contract_period', 'lawsuit_argument', 'preparation_interception', 'contract_formation', 'contract_revision', 'legal_consultation', 'issue_procuration'];


    public function SubService()
    {
        return $this->belongsTo(SubService::class, 'sub_service_id');
    }
}
