<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consent extends Model
{
    use HasFactory;

    protected $fillable = [
        'groom_id',
        'doctor_id',
        'disclosure_agreement',
        'groom_finger_print_status',
        'consent_date',
        'unit_manager',
    ];

    public function groom()
    {
        return $this->belongsTo(Groom::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
