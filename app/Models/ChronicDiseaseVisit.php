<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChronicDiseaseVisit extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

     public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

     public function chronicDisease()
    {
        return $this->belongsTo(ChronicDisease::class, 'chronic_disease_id');
    }
}
