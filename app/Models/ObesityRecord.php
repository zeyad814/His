<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObesityRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        "family_member_id",
        "doctor_id",
        "visit_id",
        "visit_date",
        "visit_type",
        "weight",
        "height",
        "nutrition_counseling",
        "dietary_plan",
        "referral",
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
