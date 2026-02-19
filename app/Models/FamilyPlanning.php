<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyPlanning extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'registration_date',
        'pregnancies_count',
        'abortions_count',
        'alive_children_count',
        'oldest_child_age',
        'youngest_child_age',
        'last_delivery_or_abortion_date',
        'has_fever_or_discharge',
        'is_breastfeeding',
        'is_using_contraception_now',
        'current_method_name',
        'used_contraception_before',
        'previous_method_name',
        'vaginal_scaring_or_ulcer',
        'vaginal_discharge',
        'prolapse',
        'uterus_position',
        'uterus_tenderness',
        'uterus_size',
        'cervix_status',
        'conclusion',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function followUps()
    {
        return $this->hasMany(FamilyPlanningFollowUp::class, 'family_planning_id');
    }
}
