<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groom extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'age',
        'is_male',
        'address',
        'date_of_examination',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function clinicalFindings()
    {
        return $this->hasMany(ClinicalFinding::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function labTests()
    {
        return $this->hasMany(LabTest::class);
    }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }

    public function consents()
    {
        return $this->hasMany(Consent::class);
    }
}
