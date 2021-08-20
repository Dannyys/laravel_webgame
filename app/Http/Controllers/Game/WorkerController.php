<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\Skill;
use App\Models\Task;
use App\Models\User;
use Laravel\Ui\Presets\React;

class WorkerController extends Controller
{
    public function show()
    {
        $workers = auth()->user()->getWorkers(['skills', 'taskWorkerGroup', 'taskWorkerGroup.task']);
        $offset = $workers->count() + 1;
        // $list = $this->items->sortBy(function($model) use ($order){
        //     return array_search($model->getKey(), $order);
        // });
        $core_skills = Skill::doesntHave('taskMods')
            ->with('requires')
            ->get();
        $mod_skills = Skill::has('taskMods')
            ->with('requires')
            ->get();

        $mining_core_skills = $core_skills->where('type', Task::TYPE_GATHER)
            ->where('sub_type', Task::GATHER_TYPE_MINING);
            // ->sortBy(function ($item) {
            //     return array_search($item->getKey(), [1, 2, 3, 4]);
            // });
        $mining_mod_skills = $mod_skills->where('type', Task::TYPE_GATHER)
            ->where('sub_type', Task::GATHER_TYPE_MINING);

        $tanning_core_skills = $core_skills->where('type', Task::TYPE_GATHER)
            ->where('sub_type', Task::GATHER_TYPE_TANNING);
        $tanning_mod_skills = $mod_skills->where('type', Task::TYPE_GATHER)
            ->where('sub_type', Task::GATHER_TYPE_TANNING);

        $weaving_core_skills = $core_skills->where('type', Task::TYPE_GATHER)
            ->where('sub_type', Task::GATHER_TYPE_WEAVING);
        $weaving_mod_skills = $mod_skills->where('type', Task::TYPE_GATHER)
            ->where('sub_type', Task::GATHER_TYPE_WEAVING);

        $biology_core_skills = $core_skills->where('type', Task::TYPE_GATHER)
            ->where('sub_type', Task::GATHER_TYPE_BIOLOGY);
        $biology_mod_skills = $mod_skills->where('type', Task::TYPE_GATHER)
            ->where('sub_type', Task::GATHER_TYPE_BIOLOGY);

        $skills_array = [
            [
                'name' => 'Mining Skills',
                'slug' => 'mining',
                'type' => Task::TYPE_GATHER,
                'sub_type' => Task::GATHER_TYPE_MINING,
                'core_skills' => $mining_core_skills,
                'mod_skills' => $mining_mod_skills
            ],
            [
                'name' => 'Tanning Skills',
                'slug' => 'tanning',
                'type' => Task::TYPE_GATHER,
                'sub_type' => Task::GATHER_TYPE_TANNING,
                'core_skills' => $tanning_core_skills,
                'mod_skills' => $tanning_mod_skills
            ],
            [
                'name' => 'Weaving Skills',
                'slug' => 'weaving',
                'type' => Task::TYPE_GATHER,
                'sub_type' => Task::GATHER_TYPE_WEAVING,
                'core_skills' => $weaving_core_skills,
                'mod_skills' => $weaving_mod_skills
            ],
            [
                'name' => 'Biology Skills',
                'slug' => 'biology',
                'type' => Task::TYPE_GATHER,
                'sub_type' => Task::GATHER_TYPE_BIOLOGY,
                'core_skills' => $biology_core_skills,
                'mod_skills' => $biology_mod_skills
            ]
        ];
        return view('game.workers', [
            'workers' => $workers,
            'skills' => $skills_array,
            'worker_cost' => isset(Worker::PRICE_TABLE[$offset]) ? Worker::PRICE_TABLE[$offset] : -1,
            'level_up_costs' => Worker::LEVEL_PRICE_TABLE,
            'can_buy_worker' => auth()->user()->canBuyWorker()
        ]);
    }

    public function buyWorker()
    {
        $user = auth()->user();
        if (!$user->canBuyWorker())
            return redirect()->route('game.workers');
        $user->buyWorker();
        return redirect()->route('game.workers');
    }

    public function learnSkill(Request $request){
        $user = auth()->user();
        $skill_id = (int)$request->input('skill_id');
        $worker_id = (int)$request->input('worker_id');
        if($skill_id <= 0 || $worker_id <= 0) return redirect()->back();
        $worker = Worker::with('skills')->where('id', $worker_id)->where('user_id', $user->id)->first();
        $skill = Skill::where('id', $skill_id)->first();
        if(!$worker || !$skill) return redirect()->back();
        if(!$worker->canLearnSkill($skill, $user)) return redirect()->back();
        $worker->learnSkill($skill);
        return redirect()->back();
    }

    public function levelUp(Request $request){
        $user = auth()->user();
        $worker_id = (int)$request->input('worker_id');
        if($worker_id <= 0) return redirect()->back();
        $worker = Worker::where('id', $worker_id)->first();
        if(!$worker->canLevelUp()) return redirect()->back();
        if($user->gold < Worker::LEVEL_PRICE_TABLE[$worker->level]['gold']) return redirect()->back();
        if($user->gems < Worker::LEVEL_PRICE_TABLE[$worker->level]['gems']) return redirect()->back();

        $user->gold -= Worker::LEVEL_PRICE_TABLE[$worker->level]['gold'];
        $user->gems -= Worker::LEVEL_PRICE_TABLE[$worker->level]['gems'];
        $user->save();
        $worker->levelUp();
        return redirect()->back();
    }
}
