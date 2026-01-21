<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiologyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'radiological_request_id',
        'doctor_id',
        'findings_text',
        'radiation_dose',
        'report_date_time',
    ];

    public function radiologicalRequest()
    {
        return $this->belongsTo(RadiologicalRequest::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
