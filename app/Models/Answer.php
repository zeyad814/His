<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'assessment_id',
        'answer_status',
        'answer_comment',
    ];

     public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function geriatricAssessment()
    {
        return $this->belongsTo(GeriatricAssessmentMaster::class);
    }
}
