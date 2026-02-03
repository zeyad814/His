<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowthVisit extends Model
{
    protected $fillable = [
        "family_member_id",
        "birth_screening_id",
        "visit_id",
        "visit_date",
        "age_stage",
        "weight_kg",
        "height_cm",
        "head_circumference_cm",
        "use_pacifier",
        "exclusive_breastfeeding",
        "supplementary_feeding",
        "bottle_feeding",
        "cup_spoon_feeding",
        "natural_breastfeeding",
        "other_foods",
        "hemoglobin_level",
        "mandatory_vaccinations",
        "other_vaccinations",
        "vaccination_date",
        "nurse_id",
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function birthScreening()
    {
        return $this->belongsTo(BirthScreening::class, 'birth_screening_id');
    }
}
