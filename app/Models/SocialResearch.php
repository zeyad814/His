<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialResearch extends Model
{
    use HasFactory;

    protected $fillable = [
        "family_id",
        "income_type",
        "avg_income",
        "has_chronic_diseases",
        "has_disability",
        "receives_pension",
        "eligible_for_free_service",
        "supporter_name_on_death",
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
