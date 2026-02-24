<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureEquipment extends Model
{
    use HasFactory;

    protected $table = 'procedure_equipments';

    protected $fillable = [
        'surgery_uterus_id',
        'name',
        'status',
    ];

    public function surgeryUterus()
    {
        return $this->belongsTo(SurgeryUterus::class, 'surgery_uterus_id');
    }
}
