<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_code',
        'national_id',
        'head_name',
        'governorate',
        'health_department',
        'village_or_city',
        'health_unit',
        'address',
        'mobile_phone',
        'work_phone',
        'nearest_phone'
    ];

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function socialResearch()
    {
        return $this->hasOne(SocialResearch::class);
    }

    public function housingInfo()
    {
        return $this->hasOne(HousingInfo::class);
    }
}
