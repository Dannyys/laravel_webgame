<?php

namespace App\Listeners;

use App\Events\GameUpdated;
use App\Events\WorkerLearnedSkill;

class TaskUnlockSubscriber
{
    public function unlockUserTasks($event)
    {
        ddd($event->user);
    }


    public function subscribe($events)
    {
        return [
            GameUpdated::class => [
                [TaskUnlockSubscriber::class, 'unlockUserTasks']
            ],
            WorkerLearnedSkill::class => [
                [TaskUnlockSubscriber::class, 'unlockUserTasks']
            ]
        ];
    }
}
