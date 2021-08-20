<div id="friends-table">
    @foreach($friends as $friend)
    <hr>
        <div class="row">
            <div class="col-3">
                FAV
            </div>
            <div class="col-9">
                {{$friend->username}}
            </div>
            <div class="col-6">
                Send gift
            </div>
            <div class="col-6">
                Remove friend
            </div>
        </div>
        <hr>
    @endforeach
    {{$friends->links('components.pagination', ['target'=>'#friends-table'])}}
</div>
