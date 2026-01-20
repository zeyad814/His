<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_administration_id',
        'name',
        'address',
        'email',
        'phone',
    ];

    public function healthAdministration()
    {
        return $this->belongsTo(HealthAdministration::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function nurses()
    {
        return $this->hasMany(Nurse::class);
    }
}
