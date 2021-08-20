<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    //Roles
    const ROLE_USER = 0;
    const ROLE_MODERATOR = 1;
    const ROLE_ADMINISTRATOR = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private $friends = null;
    private $friendRequests = null;
    private $friendInvitations = null;

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'user_material')->withPivot('amount');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'user_item')->withPivot('amount');
    }

    public function unlockedTasks()
    {
        return $this->belongsToMany(Task::class, 'user_task_unlocked');
    }

    public function hasTask($task)
    {
        return $this->unlockedTasks->contains($task);
    }

    public function workers()
    {
        return $this->hasMany(Worker::class);
    }

    public function taskWorkerGroups()
    {
        return $this->hasMany(TaskWorkerGroup::class);
    }

    public function friends(){
        return $this->belongsToMany(User::class, 'user_friend', 'user_id', 'friend_id')
            ->wherePivotIn('friend_id', function($query){
                $query->select('user_id')
                        ->from('user_friend')
                        ->where('friend_id', Auth::id());
            });
    }
    public function friendRequests(){
        return $this->belongsToMany(User::class, 'user_friend', 'user_id', 'friend_id')
            ->wherePivotNotIn('friend_id', function($query){
                $query->select('user_id')
                        ->from('user_friend')
                        ->where('friend_id', Auth::id());
            });
    }
    public function friendInvitations(){
        return $this->belongsToMany(User::class, 'user_friend', 'friend_id', 'user_id')
            ->wherePivotNotIn('user_id', function($query){
                $query->select('friend_id')
                        ->from('user_friend')
                        ->where('user_id', Auth::id());
            });
    }
    // public function getFriends(){
    //     if($this->friends) return $this->friends;
    //     $this->friends = User::whereIn('id', function($query){
    //         $query->select('friend_id')
    //             ->from('user_friend')
    //             ->where('user_id', Auth::id())
    //             ->whereIn('friend_id', function($subQuery){
    //                 $subQuery->select('user_id')
    //                     ->from('user_friend')
    //                     ->where('friend_id', Auth::id());
    //             });
    //     })->get();
    //     return $this->friends;
    // }

    public function getFriendRequests(){
        if($this->friendRequests) return $this->friendRequests;
        $this->friendRequests = User::whereIn('id', function($query){
            $query->select('friend_id')
                ->from('user_friend')
                ->where('user_id', Auth::id())
                ->whereNotIn('friend_id', function($subQuery){
                    $subQuery->select('user_id')
                        ->from('user_friend')
                        ->where('friend_id', Auth::id());
                });
        })->get();
        return $this->friendRequests;
    }

    public function getFriendInvitations(){
        if($this->friendInvitations) return $this->friendInvitations;
        $this->friendInvitations = User::whereIn('id', function($query){
            $query->select('user_id')
                ->from('user_friend')
                ->where('friend_id', Auth::id())
                ->whereNotIn('user_id', function($subQuery){
                    $subQuery->select('friend_id')
                        ->from('user_friend')
                        ->where('user_id', Auth::id());
                });
        })->get();
        return $this->friendInvitations;
    }

    public function getTaskWorkerGroups($with = [])
    {
        $this->taskWorkerGroups = $this->hasMany(TaskWorkerGroup::class)->with($with)->get();
        return $this->taskWorkerGroups;
    }

    public function getWorkers($with = [])
    {
        $this->workers = $this->hasMany(Worker::class)->with($with)->get();
        return $this->workers;
    }

    public function ownsWorkers($workers)
    {
        return $this->workers->whereIn('id', $workers->pluck('id'))->count() == $workers->count();
    }

    public function getIdleWorkers($with = [])
    {
        return $this->hasMany(Worker::class)->doesntHave('taskWorkerGroup')->with($with)->get();
    }
    public function canBuyWorker()
    {
        $offset = $this->workers->count() + 1;
        if (!isset(Worker::PRICE_TABLE[$offset]))
            return false;
        if (
            $this->gold < Worker::PRICE_TABLE[$offset]['gold']
            || $this->gems < Worker::PRICE_TABLE[$offset]['gems']
        )
            return false;
        return true;
    }

    public function buyWorker(){
        if(!$this->canBuyWorker()) return;
        $offset = $this->workers->count() + 1;
        $this->gold -= Worker::PRICE_TABLE[$offset]['gold'];
        $this->gems -= Worker::PRICE_TABLE[$offset]['gems'];
        $this->save();
        $name = collect(Worker::NAMES)->diff($this->workers->pluck('name'))->random();
        $worker = new Worker();
        $worker->name = $name;
        $worker->user()->associate($this);
        $worker->save();
    }

    public function unlockTask($task){
        if (!$task->userCanBuy())
            return;

        $this->unlockedTasks()->attach($task->id);
        foreach($task->unlocks as $unlocked_task){
            $this->unlockedTasks()->attach($unlocked_task->id);
        }
    }

    public function removeTaskCosts($task, $iterations){
        foreach($task->materialCosts as $mat_cost){
            $material = $this->materials->where('id', $mat_cost->id)->first();
            $material->pivot->amount -= $mat_cost->pivot->amount * $iterations;
            $this->materials()->updateExistingPivot($material->id, ['amount' => $material->pivot->amount]);
        }
        foreach($task->itemCosts as $item_cost){
            $item = $this->items->where('id', $item_cost->id)->first();
            $item->pivot->amount -= $item_cost->pivot->amount * $iterations;
            $this->materials()->updateExistingPivot($item->id, ['amount' => $item->pivot->amount]);
        }
    }

    public function refundTaskCosts($task, $iterations){
        foreach($task->materialCosts as $mat_cost){
            $material = $this->materials->where('id', $mat_cost->id)->first();
            $material->pivot->amount += $mat_cost->pivot->amount * $iterations;
            $this->materials()->updateExistingPivot($material->id, ['amount' => $material->pivot->amount]);
        }
        foreach($task->itemCosts as $item_cost){
            $item = $this->items->where('id', $item_cost->id)->first();
            $item->pivot->amount += $item_cost->pivot->amount * $iterations;
            $this->materials()->updateExistingPivot($item->id, ['amount' => $item->pivot->amount]);
        }
    }

    public function sellMaterial($material, $amount){
        $owned = $this->materials->where('id', $material->id)->first();
        if(!$owned) return;
        if($amount > $owned->pivot->amount) return;
        $owned->pivot->amount -= $amount;
        $this->materials()->updateExistingPivot($owned->id, ['amount' => $owned->pivot->amount]);
        $this->gold += $amount * $material->base_value;
        $this->save();
    }

    public function sellItem($item, $amount){
        $owned = $this->items->where('id', $item->id)->first();
        if(!$owned) return;
        if($amount > $owned->pivot->amount) return;
        $owned->pivot->amount -= $amount;
        $this->items()->updateExistingPivot($owned->id, ['amount' => $owned->pivot->amount]);
        $this->gold += $amount * $item->calculateValue();
        $this->save();
    }

    //TODO: Dit netter maken
    public function giveRewards($rewards){
        $rewards = collect($rewards);
        $result = collect([]);
        foreach ($rewards as $reward) {
            $item = $result->firstWhere('reward', $reward['reward']);
            if (!$item) {
                $reward['amount'] = $rewards->where('reward', $reward['reward'])->sum('amount');
                $result->push($reward);
            }
        }

        foreach ($result as $reward) {
            if ($reward['type'] == 'material')
                $this->addMaterials($reward['reward'], $reward['amount']);
            if($reward['type'] == 'item')
                $this->addItems($reward['reward'], $reward['amount']);
        }
    }

    private function addMaterials($material, $amount){
        $owned = $this->materials->where('id', $material->id)->first();
        if (!$owned) {
            $this->materials()->attach($material, ['amount' => $amount]);
            unset($this->materials);
            return;
        }

        $owned->pivot->amount += $amount;
        $this->materials()->updateExistingPivot($material->id, ['amount' => $owned->pivot->amount]);
    }

    private function addItems($item, $amount){
        $owned = $this->items->where('id', $item->id)->first();
        if(!$owned){
            $this->items()->attach($item, ['amount' => $amount]);
            unset($this->items);
            return;
        }
        $owned->pivot->amount += $amount;
        $this->items()->updateExistingPivot($item->id, ['amount' => $owned->pivot->amount]);
    }
}
