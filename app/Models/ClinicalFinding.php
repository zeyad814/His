<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalFinding extends Model
{
    use HasFactory;

    protected $fillable = [
        'groom_id',
        'vital_signs',
        'physical_measurements',
        'body_examination',
    ];

    public function groom()
    {
        return $this->belongsTo(Groom::class);
    }
}
