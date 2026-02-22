<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChronicDisease extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'family_member_id',
        'diagnosis',
        'date_diagnosed',
        'risk_factors',
    ];

    protected function casts(): array
    {
        return [
            'date_diagnosed' => 'date',
            'created_at' => 'datetime',
        ];
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }



    public function diseaseVisits()
    {
        return $this->hasMany(ChronicDiseaseVisit::class);
    }
}
