<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyInjection extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'procedure_name',
        'phone',
        'is_agreed',
        'signature_path',
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

    public function getNationalIdAttribute()
    {
        return $this->familyMember?->family?->national_id ?? 'N/A';
    }

    // public function getSignatureUrlAttribute()
    // {
    //     return $this->signature_path ? url('storage/' . $this->signature_path) : null;
    // }

}
