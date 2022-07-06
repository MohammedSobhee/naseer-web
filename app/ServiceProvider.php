<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProvider extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [
        'user_id', 'idno', 'idno_file', 'skill', 'skill_file', 'licensed', 'licensed_file',
        'bio', 'address', 'latitude', 'longitude', 'service_provider_type_id'
    ];

    protected $casts = ['service_provider_type_id' => 'integer'];


    public function Provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ServiceProviderType()
    {
        return $this->belongsTo(ServiceProviderType::class, 'service_provider_type_id');
    }

    public function getIdnoFileAttribute($value)
    {
        return storage_public($value);
    }

    public function getSkillFileAttribute($value)
    {
        return storage_public($value);
    }

    public function getLicensedFileAttribute($value)
    {
        return storage_public($value);
    }
}
