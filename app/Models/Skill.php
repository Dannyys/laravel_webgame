<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    public $timestamps = false;

    // const SKILL_TYPE_CORE = 0;
    // const
    public function requires()
    {
        return $this->belongsToMany(Skill::class, 'skill_skill_requirement', 'skill_id', 'required_skill_id');
    }

    public function unlocks()
    {
        return $this->belongsToMany(Skill::class, 'skill_skill_requirement', 'required_skill_id', 'skill_id');
    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'worker_skill');
    }

    public function taskMods()
    {
        return $this->hasMany(SkillTaskMod::class);
    }
}
