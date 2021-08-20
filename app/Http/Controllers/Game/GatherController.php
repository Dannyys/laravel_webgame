<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskWorkerGroup;
use App\Models\Worker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class GatherController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $tasks = Task::getAvailableTasks(['materialRewards', 'skillsRequired']);
        $idleWorkers = $user->getIdleWorkers(['skills']);

        $taskWorkerGroups = $user->getTaskWorkerGroups(['workers', 'workers.skills', 'workers.skills.taskMods', 'task']);

        // ddd($taskWorkerGroups[0]->workers->pluck('skills')->collapse()->pluck('taskMods')->collapse()->where('task_type', 0)->where('task_sub_type', 0));
        $mining_tasks = $tasks->where('type', TASK::TYPE_GATHER)
            ->where('sub_type', TASK::GATHER_TYPE_MINING);

        $tanning_tasks =  $tasks->where('type', TASK::TYPE_GATHER)
            ->where('sub_type', TASK::GATHER_TYPE_TANNING);

        $weaving_tasks =  $tasks->where('type', TASK::TYPE_GATHER)
            ->where('sub_type', TASK::GATHER_TYPE_WEAVING);

        $biology_tasks =  $tasks->where('type', TASK::TYPE_GATHER)
            ->where('sub_type', TASK::GATHER_TYPE_BIOLOGY);

        $tasks_array = [
            [
                'name' => 'Mining',
                'slug' => 'mining',
                'type' => Task::TYPE_GATHER,
                'sub_type' => Task::GATHER_TYPE_MINING,
                'tasks' => $mining_tasks
            ],
            [
                'name' => 'Tanning',
                'slug' => 'tanning',
                'type' => Task::TYPE_GATHER,
                'sub_type' => Task::GATHER_TYPE_TANNING,
                'tasks' => $tanning_tasks
            ],
            [
                'name' => 'Weaving',
                'slug' => 'weaving',
                'type' => Task::TYPE_GATHER,
                'sub_type' => Task::GATHER_TYPE_WEAVING,
                'tasks' => $weaving_tasks
            ],
            [
                'name' => 'Biology',
                'slug' => 'biology',
                'type' => Task::TYPE_GATHER,
                'sub_type' => Task::GATHER_TYPE_BIOLOGY,
                'tasks' => $biology_tasks
            ],
        ];
        // ddd($tasks_array);
        return view("game.gather", [
            'idleWorkers' => $idleWorkers,
            'taskWorkerGroups' => $taskWorkerGroups,
            'task_types' => $tasks_array,
            'user' => $user
        ]);
    }
    //

    public function buyTask(Request $request)
    {
        $id = (int)$request->input('task_id');
        if ($id <= 0)
            return redirect()->back();

        $task = Task::with('unlocks')->where('id', $id)->first();
        auth()->user()->unlockTask($task);

        return redirect()->back();
    }

    public function startTask(Request $request)
    {
        $task_id = (int)$request->input('task_id');
        $worker_ids = $request->input('worker_ids');
        $user = auth()->user();
        if ($task_id <= 0)
            return redirect()->back();
        if (!is_array($worker_ids))
            return redirect()->back();
        $task = Task::with('skillsRequired')->where('id', $task_id)->first();
        if (!$user->hasTask($task))
            return redirect()->back();

        $worker_ids = collect($worker_ids)->reject(function ($item) {
            return (int) $item <= 0;
        });
        $workers = Worker::with('skills')
            ->whereIn('id', $worker_ids)
            ->where('user_id', $user->id)
            ->whereNull('task_worker_group_id')
            ->get();
        $ableWorkers = $task->filterAbleWorkers($workers);

        foreach ($ableWorkers as $worker) {
            $group = new TaskWorkerGroup();
            $group->initializeGroup($task, $user);
            $group->addWorker($worker);
        }
        return redirect()->back();
    }

    public function stopTask(Request $request)
    {
        $task_worker_group_id = (int)$request->input('task_worker_group_id');
        $workerGroup = TaskWorkerGroup::where('id', $task_worker_group_id)
            ->where('user_id', auth()->user()->id)
            ->first();
        if (!$workerGroup)
            return redirect()->back();
        $workerGroup->delete();
        return redirect()->back();
    }
}
