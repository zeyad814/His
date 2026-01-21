<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'family_member_id',
        'request_date',
        'test_time',
        'priority',
        'patient_preparation',
        'diagnoses',
        'collection_date_time',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function testItems()
    {
        return $this->hasMany(LabTestItem::class);
    }
}
