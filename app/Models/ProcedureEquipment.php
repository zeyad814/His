<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureEquipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'surgery_uterus_id',
        'equipment_name',
        'available',
    ];

    public function surgeryUterus()
    {
        return $this->belongsTo(SurgeryUterus::class);
    }
}
