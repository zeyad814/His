<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'groom_id',
        'consanguinity',
        'infectious_diseases',
        'hereditary_diseases',
        'chronic_diseases',
        'family_hereditary_history',
    ];

    public function groom()
    {
        return $this->belongsTo(Groom::class);
    }
}
