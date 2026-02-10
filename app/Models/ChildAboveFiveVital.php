<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildAboveFiveVital extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'visit_id',
        'age',
        'weight',
        'height',
        'vaccine_dt',
        'vaccine_meningitis',
        'other_vaccines',
        "vaccine_date",
        'notes',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
