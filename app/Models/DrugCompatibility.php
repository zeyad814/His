<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugCompatibility extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_id',
        'doctor_id',
        'visit_date',
        'current_home_meds',
        'recommended_meds',
        'has_pharmacist_recommendation',
        'pharmacist_recommendation_text',
        'doctor_response',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
