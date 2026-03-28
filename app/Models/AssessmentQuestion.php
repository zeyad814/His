<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentQuestion extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category',
        'question_text',
        'key_name',
        'input_type',
        'options'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function answers()
    {
        return $this->hasMany(AssessmentAnswer::class);
    }
}
