<?php

namespace App\Models;

use App\Models\Doctor;
use App\Models\Pregnancy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostnatalCare extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregnancy_id',
        'doctor_id',
        'visit_date',
        'delivery_type',
        'delivery_date',
        'baby_status',
        'delivery_place',
        'attended_by',
        'delivery_complications',
        'first_pnc_visit_date',
        'first_pnc_visit_result',
        'second_pnc_visit_date',
        'second_pnc_visit_result',
        'third_pnc_visit_date',
        'third_pnc_visit_result',
        'breastfeeding_type',
        'breastfeeding_assessment',
        'breastfeeding_problems',
        'depression_screening',
        'social_adjustment',
        'maternal_concerns',
        'health_education',
        'contraception_method',
        'contraception_date',
        'additional_notes',
    ];

    public function pregnancy()
    {
        return $this->belongsTo(Pregnancy::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
