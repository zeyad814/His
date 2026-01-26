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
        'nearest_phone',
        "family_doctor_id",
        "family_doctor_assign_date",
        "dentist_id",
        "dentist_assign_date",
    ];

    public function members()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function deathRecords()
    {
        // بتجيب سجلات الوفاة من خلال أفراد الأسرة
        return $this->hasManyThrough(DeathRecord::class, FamilyMember::class);
    }

    // public function deathRecord()
    // {
    //     return $this->hasMany(DeathRecord::class);
    // }

    public function familyDoctor()
    {
        // العيلة تنتمي لطبيب أسرة محدد
        return $this->belongsTo(Doctor::class, 'family_doctor_id');
    }

    public function dentistDoctor()
    {
        // العيلة تنتمي لطبيب أسنان محدد
        return $this->belongsTo(Doctor::class, 'dentist_id');
    }

    public function socialResearch()
    {
        return $this->hasOne(SocialResearch::class);
    }

    public function housingInfo()
    {
        return $this->hasOne(HousingInfo::class);
    }

    public function headOfFamily()
    {
        return $this->hasOne(FamilyMember::class)->whereIn('relationship_to_head', ['father', 'husband']);
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'family_id');
    }
}
