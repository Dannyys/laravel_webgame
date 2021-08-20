<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    private $page_size = 1;
    //
    public function show(Request $request){
        // ddd($request);
        $user = auth()->user();
        return view('game.friends', [
            'friends' => $user->friends()->paginate($this->page_size)->withPath(route('game.friends.friends-table')),
            'invitations' => $user->friendInvitations,
            'requests' => $user->friendRequests
        ]);
    }

    public function friendsTable(){
        return view('components.friends-table', [
            'friends' => auth()->user()->friends()->paginate($this->page_size)->withPath(route('game.friends.friends-table'))
        ]);
    }
}
