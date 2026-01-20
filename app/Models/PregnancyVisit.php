<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnancyVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregnancy_id',
        'doctor_id',
        'date',
        'visit_date',
        'dental',
        'vitamins',
        'weight',
        'complications',
        'blood_pressure',
        'general_exam',
        'health_education',
        'next_visit',
        'obstetric_assessment',
        'ultrasound',
    ];

    public function pregnancy()
    {
        return $this->belongsTo(Pregnancy::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

}
