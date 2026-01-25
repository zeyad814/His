<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

      protected $fillable = [
       'family_member_id',
       'discovery_date',
       "disease_type",
       'type_of_illness',
       'note',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
}
