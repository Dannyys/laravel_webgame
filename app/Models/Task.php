<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Task extends Model
{
    use HasFactory;

    public $timestamps = false;
    //type values
    const TYPE_GATHER = 0;
    const TYPE_CRAFT = 1;

    //sub_type gathering values
    const GATHER_TYPE_MINING = 0;
    const GATHER_TYPE_TANNING = 1;
    const GATHER_TYPE_WEAVING = 2;
    const GATHER_TYPE_BIOLOGY = 3;

    //sub_type crafting values
    const CRAFT_TYPE_BLACKSMITHING = 0;
    const CRAFT_TYPE_LEATHERWORKING = 1;
    const CRAFT_TYPE_TAILORING = 2;
    const CRAFT_TYPE_ALCHEMY = 3;



    private static $availableTasks = null;
    private $maxIterations = null;

    public function workers()
    {
        return $this->hasMany(Worker::class);
    }
    public function skillsRequired()
    {
        return $this->belongsToMany(Skill::class, 'task_skill_requirement', 'task_id', 'skill_id');
    }

    public function materialCosts(){
        return $this->belongsToMany(Material::class, 'task_material_cost', 'task_id', 'material_id')->withPivot('amount');
    }
    public function materialRewards()
    {
        return $this->belongsToMany(Material::class, 'task_material_reward', 'task_id', 'material_id')->withPivot('base_amount', 'base_chance');
    }
    public function itemCosts(){
        return $this->belongsToMany(Item::class, 'task_item_cost', 'task_id', 'item_id')->withPivot('amount');
    }
    public function itemRewards(){
        return $this->belongsToMany(Item::class, 'task_item_reward', 'task_id', 'item_id')->withPivot('base_amount', 'base_chance');
    }

    public function unlocks(){
        return $this->belongsToMany(Task::class, 'task_unlocks_task', 'task_id', 'task_to_unlock_id');
    }

    public function userCanBuy()
    {
        $user = auth()->user();
        if (!Task::getAvailableTasks()->contains($this))
            return false;
        return $user->gold >= $this->gold_cost && $user->gems >= $this->gems_cost;
    }

    public function filterAbleWorkers($workers)
    {
        $requiredSkills = $this->skillsRequired;
        $filtered = $workers->filter(function ($worker) use ($requiredSkills) {
            return $requiredSkills->count() == $worker->skills->whereIn('id', $requiredSkills->pluck('id'))->count();
        });
        return $filtered;
    }

    public function calculateMaxIterations(){
        if($this->maxIterations)
            return $this->maxIterations;
        $max = null;
        $user = auth()->user();
        foreach($this->materialCosts as $mat_cost){
            $user_mat = $user->materials->where('id', $mat_cost->id)->first();
            if(!$user_mat){
                $max = 0;
                break;
            }
            $new_max = (int) floor($user_mat->pivot->amount / $mat_cost->pivot->amount);
            if($new_max < $max || $max == null)
                $max = $new_max;
        }
        foreach($this->itemCosts as $item_cost){
            $user_item = $user->items->where('id', $item_cost->id)->first();
            if(!$user_item){
                $max = 0;
                break;
            }
            $new_max = (int) floor($user_item->pivot->amount / $item_cost->pivot->amount);
            if($new_max < $max || $max == null)
                $max = $new_max;
        }
        $this->maxIterations = $max;
        return $max;
    }
    public static function getAvailableTasks($with = [])
    {
        if (!empty(Task::$availableTasks))
            return Task::$availableTasks;
        Task::$availableTasks = Task::with($with)
            ->whereNotIn('id', function ($reqQuery) {
                $reqQuery->select('task_id')
                    ->from('task_skill_requirement')
                    ->whereNotIn('skill_id', function ($skillQuery) {
                        $skillQuery->select('skill_id')
                            ->from('worker_skill')
                            ->whereIn('worker_id', function ($workerQuery) {
                                $workerQuery->select('id')
                                    ->from('workers')
                                    ->where('user_id', Auth::id());
                            })
                            ->groupBy('skill_id');
                    });
            })->get();
        return Task::$availableTasks;
    }
}
