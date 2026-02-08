<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildGrowthMeasurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'visit_id',
        'age_months',
        'head_circumference',
        'weight',
        "height"
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }
}
