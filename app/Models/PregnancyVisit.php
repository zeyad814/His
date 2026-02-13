<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Pregnancy;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnancyVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregnancy_id',
        'doctor_id',
        'visit_id',
        'visit_date',
        'next_visit',
        'weight',
        'blood_pressure',
        'general_exam',
        'fundal_height',
        'fetal_lie',
        'fetal_heart_rate',
        'fetal_movement',
        'ultrasound',
        'urine_analysis',
        'hemoglobin',
        'blood_glucose',
        'dental',
        'vitamins',
        'health_education',
        'complications',
    ];

    public function pregnancy()
    {
        return $this->belongsTo(Pregnancy::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

}
