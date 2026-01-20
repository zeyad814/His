<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'groom_id',
        'general_health_recs',
        'genetic_recs',
        'specialist_referral',
        'additional_tests_required',
    ];

    public function groom()
    {
        return $this->belongsTo(Groom::class);
    }
}
