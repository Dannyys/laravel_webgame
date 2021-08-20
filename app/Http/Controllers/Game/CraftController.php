<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Worker;
use App\Models\TaskWorkerGroup;
use Carbon\Carbon;

class CraftController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $tasks = Task::getAvailableTasks(['materialRewards', 'materialCosts', 'itemRewards', 'itemCosts', 'skillsRequired']);
        $idleWorkers = $user->getIdleWorkers(['skills']);

        $taskWorkerGroups = $user->getTaskWorkerGroups(['workers', 'workers.skills', 'workers.skills.taskMods', 'task']);

        $blacksmithing_tasks = $tasks->where('type', Task::TYPE_CRAFT)
            ->where('sub_type', Task::CRAFT_TYPE_BLACKSMITHING);

        $leatherworking_tasks = $tasks->where('type', Task::TYPE_CRAFT)
            ->where('sub_type', Task::CRAFT_TYPE_LEATHERWORKING);

        $tailoring_tasks = $tasks->where('type', Task::TYPE_CRAFT)
            ->where('sub_type', Task::CRAFT_TYPE_TAILORING);

        $alchemy_tasks = $tasks->where('type', Task::TYPE_CRAFT)
            ->where('sub_type', Task::CRAFT_TYPE_ALCHEMY);

        $tasks_array = [
            [
                'name' => 'Blacksmithing',
                'slug' => 'blacksmithing',
                'type' => Task::TYPE_CRAFT,
                'sub_type' => Task::CRAFT_TYPE_BLACKSMITHING,
                'tasks' => $blacksmithing_tasks
            ],
            [
                'name' => 'Leatherworking',
                'slug' => 'leatherworking',
                'type' => Task::TYPE_CRAFT,
                'sub_type' => Task::CRAFT_TYPE_LEATHERWORKING,
                'tasks' => $leatherworking_tasks
            ],
            [
                'name' => 'Tailoring',
                'slug' => 'tailoring',
                'type' => Task::TYPE_CRAFT,
                'sub_type' => Task::CRAFT_TYPE_TAILORING,
                'tasks' => $tailoring_tasks
            ],
            [
                'name' => 'Alchemy',
                'slug' => 'alchemy',
                'type' => Task::TYPE_CRAFT,
                'sub_type' => Task::CRAFT_TYPE_ALCHEMY,
                'tasks' => $alchemy_tasks
            ],
        ];
        return view('game.craft',[
            'idleWorkers' => $idleWorkers,
            'taskWorkerGroups' => $taskWorkerGroups,
            'task_types' => $tasks_array,
            'user' => $user
        ]);
    }
    //

    public function startTask(Request $request){
        $task_id = (int)$request->input('task_id');
        $worker_id = (int)$request->input('worker_id');
        $iterations = (int)$request->input('iterations');
        $user = auth()->user();
        if ($task_id <= 0)
            return redirect()->back();
        if ($worker_id <= 0)
            return redirect()->back();
        if ($iterations <= 0)
            return redirect()->back();
        $task = Task::with(['skillsRequired', 'materialCosts', 'itemCosts'])->where('id', $task_id)->first();
        if (!$user->hasTask($task))
            return redirect()->back();
        if($iterations > $task->calculateMaxIterations())
            return redirect()->back();

        $workers = Worker::with('skills')
            ->where('id', $worker_id)
            ->where('user_id', $user->id)
            ->whereNull('task_worker_group_id')
            ->get();
        $ableWorker = $task->filterAbleWorkers($workers)->first();
        if(!$ableWorker)
            return redirect()->back();

        $user->removeTaskCosts($task, $iterations);
        $group = new TaskWorkerGroup();
        $group->initializeGroup($task, $user, $iterations);
        $group->addWorker($ableWorker);

        return redirect()->back();
    }

    public function stopTask(Request $request){
        $task_worker_group_id = $request->input('task_worker_group_id');
        $workerGroup = TaskWorkerGroup::where('id', $task_worker_group_id)
            ->where('user_id', auth()->user()->id)
            ->with(['task', 'task.materialCosts', 'task.itemCosts'])
            ->first();

        if (!$workerGroup)
            return redirect()->back();

        auth()->user()->refundTaskCosts($workerGroup->task, $workerGroup->task_iterations);
        $workerGroup->delete();
        return redirect()->back();
    }
}
