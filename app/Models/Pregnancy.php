<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregnancy extends Model
{
    use HasFactory;

    protected $fillable = [
       'family_member_id',
       'last_menstrual_period',
       'expected_delivery_date',
       'pregnancy_status',
       'gravidity',
       'parity',
       'abortions',
       'living_children',
       'previous_stillbirths',
       'previous_cesarean',
       'blood_type',
       'rh_factor',
       'syphilis_test_result',
       'last_tetanus_date',
       'tetanus_doses',
       'tetanus_immunity_status',
       'consanguinity',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }

    public function pregnancyVisits()
    {
        return $this->hasMany(PregnancyVisit::class);
    }
}
