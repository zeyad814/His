<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'death_date',
        'age_at_death',
        'cause_of_death',
        'death_code',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
}
