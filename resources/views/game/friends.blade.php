@extends('layouts.content.game')

@section('content')
    <div class="container game-content">
        <div class="accordion" id="friends-accordion">

                <div class="card">
                    <div class="card-header">
                        <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#friends-body" aria-expanded="true" aria-controls="friends-body">
                            Friends
                        </button>
                        </h2>
                    </div>
                    <div id="friends-body" class="collapse show" data-parent="#friends-accordion">
                        <div class="card-body">
                            @include('components.friends-table', ['friends' => $friends])
                        </div>
                    </div>
                </div>

        </div>
        {{-- <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-friends" role="tabpanel" aria-labelledby="nav-friends-tab">
                <div class="row">
                    <div class="col-12">
                        <div id="worker-{{$worker->id}}-{{$skill['slug']}}" class="collapse" data-parent="#accordion-{{$worker->id}}">
                            <div class="card-body">

                            </div>
                        </div>
                        <table class="table">
                            <tbody>
                                @foreach($friends as $friend)
                                    <tr>
                                        <td>Fav</td>
                                        <td>{{$friend->username}}</td>
                                        <td>Send gift, Remove friend</td>
                                    </tr>
                                @endforeach
                                {{$friends->links('components.pagination')}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-invites" role="tabpanel" aria-labelledby="nav-invites-tab">
                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <tbody>
                                @foreach($invitations as $friend)
                                    <tr>
                                        <td>{{$friend->username}}</td>
                                        <td>Accept, Deny</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-requests" role="tabpanel" aria-labelledby="nav-requests-tab">
                <div class="row">
                    <div class="col-12">
                        <table class="table">
                            <tbody>
                                @foreach($requests as $friend)
                                    <tr>
                                        <td>{{$friend->username}}</td>
                                        <td>Cancel</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
