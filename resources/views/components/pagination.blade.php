
<div class="pagination">
    @if($paginator->previousPageUrl())
        <a href="{{$paginator->url(1)}}" data-target="{{$target}}">first</a>
        <a href="{{$paginator->previousPageUrl()}}" data-target="{{$target}}">prev</a>
    @endif
    @for($i = $paginator->currentPage() -2; $i <= $paginator->currentPage() +2; $i++)
        @if($i < 1 || $i > $paginator->lastPage())
            @continue
        @endif
        <a href="{{$paginator->url($i)}}" data-target="{{$target}}">{{$i}}</a>
    @endfor
    @if($paginator->nextPageUrl())
        <a href="{{$paginator->nextPageUrl()}}" data-target="{{$target}}">next</a>
        <a href="{{$paginator->url($paginator->lastPage())}}" data-target="{{$target}}">last</a>
    @endif
</div>
