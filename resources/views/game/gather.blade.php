@extends('layouts.content.game')

@section('content')
    <div class="container game-content">
        @foreach ($task_types as $task_type)
            @if($task_type['tasks']->count() == 0)
                @continue
            @endif
            <h3 class="{{ $loop->first ? "" : "mt-4" }}">{{$task_type['name']}}</h3>
            <hr class="my-4">
            <div class="row pb-4">
                @foreach($task_type['tasks'] as $task)
                    <div class="col-12 col-lg-6 mt-20">
                        <div class="card">
                            <div class="card-header d-flex">
                                <span>{{$task->name}}</span>
                                @if(!$user->hasTask($task))
                                    <span class="ml-auto">Locked</span>
                                @endif
                            </div>
                            <div class="card-body">
                                @foreach($task->materialRewards as $reward)
                                    <div class="row">
                                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">{{$reward->name}}</div>
                                        <div class="col-7 col-lg-4 col-md-4 col-sm-4">{{$reward->pivot->base_amount}}</div>
                                        <div class="col-5 col-lg-2 col-md-2 col-sm-2 d-flex justify-content-end">{{$reward->pivot->base_chance}}%</div>
                                    </div>
                                @endforeach


                                @if($user->hasTask($task))
                                    <h4 class="pt-4">Workers</h4>
                                    <hr >
                                    @php
                                        $ableWorkers = $task->filterAbleWorkers($idleWorkers);
                                    @endphp
                                    @if($ableWorkers->count() > 0)
                                        <form class="w-100 my-2 d-flex flex-column flex-sm-row" method="POST" action="{{route('game.gather.starttask')}}">
                                            @csrf
                                            <select class="custom-select w-100" name="worker_ids[]" multiple>
                                                @foreach($ableWorkers as $worker)
                                                    <option value="{{$worker->id}}">{{$worker->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="my-2 mx-2"></div>
                                            <input name="task_id" type="hidden" value="{{$task->id}}">
                                            <button type="submit" class="btn btn-primary w-100">Start working</button>
                                        </form>
                                    @endif
                                @endif

                                @foreach($taskWorkerGroups->where('task_id', $task->id) as $workerGroup)
                                    <div class="row">
                                        <div class="col-12 d-flex w-100">
                                            <div class="alert alert-info w-100">
                                                <div class="container">
                                                    @foreach($workerGroup->workers as $worker)
                                                        <div class="row">
                                                            <div class="col-12 d-flex justify-content-center mb-2">
                                                                {{$worker->name}}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <hr class="my-2">
                                                    @foreach($task->materialRewards as $reward)
                                                        <div class="row">
                                                            <div class="col-12 col-lg-6 col-md-6 col-sm-6">{{$reward->name}}</div>
                                                            <div class="col-7 col-lg-4 col-md-4 col-sm-4">{{$workerGroup->calculateRewardAmount($reward)}}</div>
                                                            <div class="col-5 col-lg-2 col-md-2 col-sm-2 d-flex justify-content-end">{{$workerGroup->calculateRewardPercentage($reward)}}%</div>
                                                        </div>
                                                        <hr class="my-2">
                                                    @endforeach
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="progress my-3">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{$workerGroup->calculateProgress()}}%" aria-valuenow="{{$workerGroup->calculateProgress()}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-12 col-lg-6 col-md-6 col-sm-6">
                                                            <form class="w-100 my-2" method="POST" action="{{route('game.gather.stoptask')}}">
                                                                @csrf
                                                                <input name="task_worker_group_id" type="hidden" value="{{$workerGroup->id}}">
                                                                <button type="submit" class="btn btn-primary w-100">Stop working</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if(!$user->hasTask($task))
                                    <form method="POST" action="{{route('game.gather.buytask')}}">
                                        @csrf
                                        <input name="task_id" type="hidden" value="{{$task->id}}">
                                        <button type="submit" class="btn btn-primary" {{$task->userCanBuy() ? "" : "disabled"}}>
                                            Unlock for {{$task->gold_cost}} gold {{!empty($task->gems_cost) ? "and ".$task->gems_cost." gems" : ""}}
                                        </button>
                                    </form>
                                @else
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endsection
