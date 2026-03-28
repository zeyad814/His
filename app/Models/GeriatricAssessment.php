<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeriatricAssessment extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'overall_status',
        'doctor_recommendations'
    ];

    protected static function booted()
    {
        static::deleting(function ($assessment) {
            // ده هيخلي الإجابات تاخد deleted_at أوتوماتيك
            $assessment->answers()->delete();
        });
    }


    public function answers()
    {
        return $this->hasMany(AssessmentAnswer::class);
    }



    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
