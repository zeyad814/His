<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentAnswer extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'geriatric_assessment_id',
        'assessment_question_id',
        'answer_value'
    ];

    public function assessment()
    {
        return $this->belongsTo(GeriatricAssessment::class, 'geriatric_assessment_id');
    }

    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class, 'assessment_question_id');
    }
}
