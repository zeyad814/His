<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyPlanningFollowUp extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'family_planning_id',
        'doctor_id',
        'visit_date',
        'get_method',
        'change_method',
        'follow_up_current_method',
        'medical_complications',
        'remove_iud',
        'remove_capsule',
        'reproductive_health',
        'counseling',
        'referral',
        'treatment',
        'dispensed_method',
        'quantity',
        'next_visit_date',
        'notes',
    ];

    public function familyPlanning()
    {
        return $this->belongsTo(FamilyPlanning::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
