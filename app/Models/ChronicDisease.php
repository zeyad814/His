<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChronicDisease extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'diagnosis',
        'date_diagnosed',
        'risk_factors',
        'complain',
        'exam',
        'vital_signs',
        'investigations',
        'management',
        'notes',
        'visit_date',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

     public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
