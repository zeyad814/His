<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToothStatus extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "dental_examination_id",
        "tooth_number",
        "crown_status",
        "root_status",
    ];

    public function dentalExamination()
    {
        return $this->belongsTo(DentalExamination::class);
    }
}
