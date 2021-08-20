@extends('layouts.content.game')

@section('content')
    <div class="container game-content">
        <h3>Materials</h3>
        <hr class="my-4">
        <div class="row">
            @foreach ($materials as $material)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-20">
                    <div class="card">
                        <div class="card-header">
                            {{$material->name}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <span class="col-12">Owned: {{$material->pivot->amount}}</span>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <span>Value: {{$material->base_value}}</span>
                                </div>
                            </div>
                            <form class="w-100 my-2 d-flex flex-column" method="POST" action="{{route('game.inventory.sellmaterial')}}">
                                @csrf
                                <input name="material_id" type="hidden" value="{{$material->id}}">
                                <input type="number" name="amount" min="1" max="{{$material->pivot->amount}}" value="1">
                                <div class="my-2 mx-2"></div>
                                <button type="submit" class="btn btn-primary w-100" {{$material->pivot->amount == 0 ? "disabled" : ""}}>Sell</button>
                            </form>
                            {{-- <p class="card-text text-danger">Currently gathering</p> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <h3 class="my-4">Items</h3>
        <hr class="my-4">
        <div class="row">
            @foreach ($items as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mt-20">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-10">
                                    {{$item->name}}
                                </div>
                            </div>
                            @if($item->value_mod < 0)
                                <span class="badge badge-pill badge-danger position-absolute item-price-mod-badge">{{$item->value_mod}}%</span>
                            @elseif($item->value_mod > 0)
                                <span class="badge badge-pill badge-success position-absolute item-price-mod-badge">+{{$item->value_mod}}%</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <span class="col-12">Owned: {{$item->pivot->amount}}</span>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    @if($item->value_mod < 0)
                                        <span>Value:</span> <del>{{$item->base_value}}</del> <span class="text-danger">{{$item->calculateValue()}}</span>
                                    @elseif($item->value_mod > 0)
                                        <span>Value:</span> <del>{{$item->base_value}}</del> <span class="text-success">{{$item->calculateValue()}}</span>
                                    @else
                                        <span>Value: {{$item->base_value}}</span>
                                    @endif
                                </div>
                            </div>
                            <form class="w-100 my-2 d-flex flex-column" method="POST" action="{{route('game.inventory.sellitem')}}">
                                @csrf
                                <input name="item_id" type="hidden" value="{{$item->id}}">
                                <input type="number" name="amount" min="1" max="{{$item->pivot->amount}}" value="1">
                                <div class="my-2 mx-2"></div>
                                <button type="submit" class="btn btn-primary w-100" {{$item->pivot->amount == 0 ? "disabled" : ""}}>Sell</button>
                            </form>
                            {{-- <p class="card-text text-danger">Currently gathering</p> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
