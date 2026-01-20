<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'groom_id',
        'test',
        'result_file',
    ];

    public function groom()
    {
        return $this->belongsTo(Groom::class);
    }
}
