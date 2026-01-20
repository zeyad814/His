<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'rooms_count',
        'sleeping_rooms_specified',
        'ventilation',
        'water_source',
        'sanitation_type',
        'lighting_type',
        'has_animals',
        'barn_location',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
