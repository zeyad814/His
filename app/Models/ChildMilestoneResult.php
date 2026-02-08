<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildMilestoneResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'visit_id',
        'milestone_lookup_id',
        'is_achieved',
    ];

    public function milestone()
    {
        return $this->belongsTo(DevelopmentalMilestoneLookup::class, 'milestone_lookup_id');
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }
}
