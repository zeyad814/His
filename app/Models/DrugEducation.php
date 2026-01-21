<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_id',
        'drug_name',
        'usage_details',
        'special_instructions',
        'side_effects',
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
}
