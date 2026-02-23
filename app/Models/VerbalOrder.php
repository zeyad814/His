<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VerbalOrder extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "family_member_id",
        "instructions",
        "order_date_time",
        "ordered_by_doctor_id",
        "recorded_by_nurse_id",
        "is_confirmed",
        "confirmed_by_doctor_id",
        "confirmation_date_time",
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function orderedByDoctor()
    {
        return $this->belongsTo(Doctor::class, 'ordered_by_doctor_id');
    }

    public function recordedByNurse()
    {
        return $this->belongsTo(Nurse::class, 'recorded_by_nurse_id');
    }

    public function confirmedByDoctor()
    {
        return $this->belongsTo(Doctor::class, 'confirmed_by_doctor_id');
    }
}
