<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'family_id',
        'health_unit_id',
        'national_id',
        'name',
        'phone',
        'specialization',
        'license_number',
        'start_date',
    ];

    public function familyFollowUps()
    {
        // الدكتور كـ "طبيب أسرة" بيتابع عائلات كتير
        return $this->hasMany(Family::class, 'family_doctor_id');
    }

    public function dentistFollowUps()
    {
        // الدكتور كـ "طبيب أسنان" بيتابع عائلات كتير
        return $this->hasMany(Family::class, 'dentist_id');
    }

    public function healthUnit()
    {
        return $this->belongsTo(HealthUnit::class);
    }

    public function significantData()
    {
        return $this->hasMany(SignificantData::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function hypertensionFollowUps()
    {
        return $this->hasMany(HypertensionFollowUp::class);
    }

    public function diabetesFollowUps()
    {
        return $this->hasMany(DiabetesFollowUp::class);
    }

    public function chronicDiseases()
    {
        return $this->hasMany(ChronicDisease::class);
    }

    public function pregnancyVisits()
    {
        return $this->hasMany(PregnancyVisit::class);
    }

    public function surgeyUterus()
    {
        return $this->hasMany(SurgeryUterus::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
