<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_unit_id',
        'national_id',
        'name',
        'phone',
        'start_date',
    ];

    public function healthUnit()
    {
        return $this->belongsTo(HealthUnit::class);
    }

    public function surgeyUterus()
    {
        return $this->hasMany(SurgeryUterus::class);
    }
}
