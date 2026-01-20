<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialResearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'income_level',
        'avg_income',
        'chronic_diseases',
        'free_service',
        'pension',
        'disability',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
