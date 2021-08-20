@extends('layouts/sitewrapper')

@section('body')

    <body class="game">
        <header>
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <ul class="navbar-nav score-navbar d-flex d-md-none">
                        <li class="nav-item">
                            <span class="nav-link">Gold: {{auth()->user()->gold}}</span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">Gems: {{auth()->user()->gems}}</span>
                        </li>
                    </ul>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Right Side Of Navbar -->
                        <div class="d-flex justify-content-between w-100 inner-nav-wrapper">

                            <ul class="navbar-nav">
                                <!-- Authentication Links -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('game.inventory') }}">{{ __('Inventory') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('game.workers') }}">{{ __('Workers') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('game.gather') }}">{{ __('Gather') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('game.craft') }}">{{ __('Craft') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="socialDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{__('Social')}}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="socialDropdown">
                                        <a class="dropdown-item" href="{{ route('game.friends') }}">{{ __('Friends') }}</a>
                                    </div>
                                </li>
                            </ul>
                            <ul class="navbar-nav">
                                <li class="nav-item d-none d-md-block">
                                    <span class="nav-link">Gold: {{auth()->user()->gold}}</span>
                                </li>
                                <li class="nav-item d-none d-md-block">
                                    <span class="nav-link">Gems: {{auth()->user()->gems}}</span>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        @yield('main')
    </body>
@endsection
