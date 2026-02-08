<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DevelopmentalMilestoneLookup extends Model
{
    use HasFactory;
    protected $table = 'developmental_milestone_lookups';
    protected $fillable = [
        'age_range',
        'question_text_ar',
    ];
    
    public function results()
    {
        return $this->hasMany(ChildMilestoneResult::class, 'milestone_lookup_id');
    }
}
