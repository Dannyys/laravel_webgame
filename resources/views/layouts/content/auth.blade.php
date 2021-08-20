@extends('layouts.public')

@section('main')

<main>
    <div class="container">
        <div class="row justify-content-center align-items-center vh100">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @yield ('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection
