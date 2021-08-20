<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CompleteTasks
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user)
            return $next($request);
        $workerGroups = $user->getTaskWorkerGroups(['task', 'task.materialRewards', 'task.itemRewards', 'workers', 'workers.skills', 'workers.skills.taskMods']);
        $rewards = [];
        foreach ($workerGroups as $group) {
            $iterations = $group->calculateIterationsCompleted();
            if($iterations == 0) continue;
            $rewards = array_merge($rewards, $group->calculateRewards($iterations));
            $group->awardWorkerExperience($iterations);
            $group->updateTime($iterations);
        }
        $user->giveRewards($rewards);
        return $next($request);
    }
}
