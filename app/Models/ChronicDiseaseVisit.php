<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChronicDiseaseVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'chronic_disease_id',
        'doctor_id',
        'visit_id',
        'complain',
        'exam',
        'vital_signs',
        'investigations',
        'management',
        'notes',
        'visit_date',
    ];

     public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

     public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

     public function chronicDisease()
    {
        return $this->belongsTo(ChronicDisease::class);
    }
}
