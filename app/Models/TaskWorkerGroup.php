<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class TaskWorkerGroup extends Model
{
    use HasFactory;
    protected $table = 'task_worker_groups';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;

    private static $userWorkerGroups = null;

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::uuid4());
        });
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function workers()
    {
        return $this->hasMany(Worker::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function finishesAt()
    {
        $carbon = new Carbon($this->task_started_at);
        return $carbon->add($this->task->base_time, 'minutes');
    }


    public function initializeGroup($task, $user, $iterations = null){
        $this->task()->associate($task);
        $this->user()->associate($user);
        $this->task_started_at = Carbon::now();
        $this->task_iterations = $iterations;
        $this->save();
    }
    public function addWorker($worker){
        $worker->taskWorkerGroup()->associate($this);
        $worker->save();
    }
    private function getSkillMods()
    {
        return $this->workers
            ->pluck('skills')
            ->collapse()
            ->pluck('taskMods')
            ->collapse()
            ->where('task_type', $this->task->type)
            ->where('task_sub_type', $this->task->sub_type);
    }

    public function calculateRewardPercentage($reward)
    {
        $modifier = ($reward->pivot->base_chance / 100) * $this->getSkillMods()->sum('chance_modifier');
        $result = round($reward->pivot->base_chance + $modifier);
        return $result > 200 ? 200 : $result;
    }

    public function calculateRewardAmount($reward)
    {
        $modifier = ($reward->pivot->base_amount / 100) * $this->getSkillMods()->sum('reward_modifier');
        return (float) round($reward->pivot->base_amount + $modifier);
    }

    public function calculateProgress()
    {
        if (Carbon::now() >= $this->finishesAt())
            return 100;
        return round((Carbon::now()->diffInMinutes(new Carbon($this->task_started_at)) / $this->task->base_time) * 100);
    }

    public function calculateIterationsCompleted()
    {
        $amountCompleted = floor(Carbon::now()->diffInMinutes(new Carbon($this->task_started_at)) / $this->task->base_time);
        return !is_null($this->task_iterations) ? min([$amountCompleted, $this->task_iterations]) : $amountCompleted;
    }


    public function awardWorkerExperience($iterations){
        if (!$this->canDoIterations($iterations)) return;
        $experience = $iterations * $this->task->experience_reward;
        foreach($this->workers as $worker){
            $worker->addExperience($experience);
        }
    }
    public function updateTime($iterations){
        if (!$this->canDoIterations($iterations)) return;
        $this->task_iterations = !is_null($this->task_iterations) ? $this->task_iterations - $iterations : null;
        if($this->task_iterations === 0){
            $this->delete();
            return;
        }
        $carbon = new Carbon($this->task_started_at);
        $carbon->addMinutes($iterations * $this->task->base_time);
        $this->task_started_at = $carbon;
        $this->save();
    }
    private function canDoIterations($iterations){
        return is_null($this->task_iterations) || $iterations <= $this->task_iterations;
    }

    //TODO: nettere oplossing hiervoor
    public function calculateRewards($iterations){
        if (!$this->canDoIterations($iterations)) return[];
        $result = [];
        $result = array_merge($this->rewardsToArray($this->task->materialRewards, $iterations, 'material'), $result);
        $result = array_merge($this->rewardsToArray($this->task->itemRewards, $iterations, 'item'), $result);
        return $result;
    }

    private function rewardsToArray($rewards, $iterations, $type)
    {
        $result = [];
        foreach ($rewards as $reward) {
            $chance = $this->calculateRewardPercentage($reward);
            $result[] = [
                'reward' => $reward,
                'amount' => $this->calculateRewardAmount($reward) * $this->calculateRolls($iterations, $chance),
                'type' => $type
            ];
        }
        return $result;
    }

    private function calculateRolls($iterations, $chance){
        if($iterations >= 100)
            return (int)floor($iterations * ($chance / 100));
        $result = 0;
        for ($x = 1; $x <= $iterations; $x++) {
            $result += $chance >= rand(1, 100) ? 1 : 0;
            if ($chance > 100) $result += ($chance - 100) >= rand(1, 100) ? 1 : 0;
        }
        return $result;
    }
    // public static function getUserWorkerGroups($with = [])
    // {
    //     if (!empty(TaskWorkerGroup::$userWorkerGroups))
    //         return TaskWorkerGroup::$userWorkerGroups;
    //     TaskWorkerGroup::$userWorkerGroups = TaskWorkerGroup::with($with)->whereIn('id', function ($query) {
    //         $query->select('task_worker_group_id')->from('workers')->where('user_id', Auth::id());
    //     })->get();
    //     return TaskWorkerGroup::$userWorkerGroups;
    // }
}
