<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTestItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_request_id',
        'test_category',
        'test_name',
    ];

    public function labRequest()
    {
        return $this->belongsTo(LabRequest::class);
    }
}
