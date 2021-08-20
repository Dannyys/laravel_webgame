<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillTaskMod extends Model
{
    use HasFactory;
    protected $table = 'skill_task_modifier';
    public $timestamps = false;

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
