@extends('layouts.content.game')

@section('content')
    <div class="container game-content">
        <h3>Workers</h3>
        <hr class="my-4">
        <div class="row">
            @foreach ($workers as $worker)
            <div class="col-12 col-lg-6 mt-20">
                <div class="card">
                    <div class="card-header d-flex">
                        <span>{{$worker->name}}</span>
                        <span class="ml-auto">Level: {{$worker->level}}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($worker->canLevelUp())
                                <div class="col-12">
                                    <form method="POST" action="{{route('game.workers.levelup')}}">
                                        @csrf
                                        <input type="hidden" name="worker_id" value="{{$worker->id}}">
                                        <button type="submit" class="btn btn-primary w-100">
                                            Level up for {{$level_up_costs[$worker->level]['gold']}} gold and {{$level_up_costs[$worker->level]['gems']}} gems
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if($worker->taskWorkerGroup)
                                <div class="col-6 d-flex">
                                    <span class="alert alert-info mb-0">{{$worker->taskWorkerGroup->task->name}}</span>
                                </div>
                            @else
                                <div class="col-6 d-flex">
                                    <span class="alert alert-danger mb-0">Idle</span>
                                </div>
                            @endif
                            <div class="col-6 d-flex justify-content-end align-items-center">
                                @if($worker->getExpString())
                                    <span>Exp: {{$worker->getExpString()}}</span>
                                @endif
                            </div>
                            @if($worker->skill_points)
                                <div class="col-12 d-flex">
                                    <span class="alert alert-success mb-0">{{$worker->skill_points}} Skillpoint</span>
                                </div>
                            @endif

                        </div>


                        <div class="row my-4">
                            <div class="col-6">
                                <a class="btn btn-primary" data-toggle="collapse" href="#worker-{{$worker->id}}-info" role="button" aria-expanded="false" aria-controls="worker-{{$worker->id}}-info">
                                    More info
                                </a>
                            </div>
                            <div class="col-6">

                            </div>
                        </div>


                        <div class="collapse" id="worker-{{$worker->id}}-info">
                            <div class="accordion" id="accordion-{{$worker->id}}">
                                @foreach($skills as $skill)
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#worker-{{$worker->id}}-{{$skill['slug']}}" aria-expanded="true" aria-controls="worker-{{$worker->id}}-{{$skill['slug']}}">
                                                {{$skill['name']}} {{$worker->skillAmount($skill['type'], $skill['sub_type'])}}
                                            </button>
                                            </h2>
                                        </div>
                                        <div id="worker-{{$worker->id}}-{{$skill['slug']}}" class="collapse" data-parent="#accordion-{{$worker->id}}">
                                            <div class="card-body">
                                                <ul>
                                                    @foreach ($skill['core_skills'] as $core_skill)
                                                        @if($worker->hasSkill($core_skill))
                                                            <li>{{$core_skill->name}}</li>
                                                        @elseif($worker->canLearnSkill($core_skill, auth()->user()))
                                                            <li>
                                                                {{$core_skill->name}}
                                                                <form method="POST" action="{{route('game.workers.learnskill')}}">
                                                                    @csrf
                                                                    <input type="hidden" name="skill_id" value="{{$core_skill->id}}">
                                                                    <input type="hidden" name="worker_id" value="{{$worker->id}}">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Learn
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                                <hr>
                                                <ul>
                                                    @foreach ($skill['mod_skills'] as $mod_skill)
                                                        @if($worker->hasSkill($mod_skill))
                                                            <li>{{$mod_skill->name}}</li>
                                                        @elseif($worker->canLearnSkill($mod_skill, auth()->user()))
                                                            <li>
                                                                {{$mod_skill->name}}
                                                                <form method="POST" action="{{route('game.workers.learnskill')}}">
                                                                    @csrf
                                                                    <input type="hidden" name="skill_id" value="{{$mod_skill->id}}">
                                                                    <input type="hidden" name="worker_id" value="{{$worker->id}}">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Learn
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- <p class="card-text text-danger">Currently gathering</p> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <hr class="my-4">
        @if($worker_cost !== -1)
        <form method="POST" action="{{route('game.workers.buyworker')}}">
            @csrf
            <button type="submit" class="btn btn-primary"  {{$can_buy_worker ? "" : "disabled"}}>
                @if($worker_cost['gold'] == 0 && $worker_cost['gems'] == 0)
                    Get your first worker for free!
                @else
                    Hire worker for {{$worker_cost['gold']}} gold {{$worker_cost['gems'] > 0 ? "and ".$worker_cost['gems']." gems" : ""}}
                @endif

            </button>
        </form>

        @endif
    </div>
@endsection
