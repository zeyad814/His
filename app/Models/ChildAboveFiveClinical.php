<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildAboveFiveClinical extends Model
{
    use HasFactory;

    protected $fillable = [
        "family_member_id",
        "doctor_id",
        "visit_id",
        "age",
        "clinical_assessment",
        "nutritional_assessment",
        "psychiatric_screening",
        "school_achievement",
        "hb",
        "urine",
        "stool",
        "other_investigations",
        "health_ed_parents",
        "health_ed_child",
        "remarks",
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
