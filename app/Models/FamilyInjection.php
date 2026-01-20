<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyInjection extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'procedure_name',
        'phone',
        'visit_date',
        'visit_time',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
