<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'clinic_name',
        'visit_date',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function drugEducations()
    {
        return $this->hasMany(DrugEducation::class);
    }

    public function drugCompatibilities()
    {
        return $this->hasMany(DrugCompatibility::class);
    }
}
