<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignificantData extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'family_member_id',
        'record_date',
        'case_description',
        "action_doctor_name",
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
}
