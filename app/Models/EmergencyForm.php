<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'nurse_id',
        'arrival_time',
        'chief_complaint',
        'triage_level',
        'triage_time',
        'exit_time',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class);
    }
}
