<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <title>Test Admin for JDB</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

        @if(empty(auth()->user()->admin) || !auth()->user()->admin)
            <style>
                .menuel {
                    width: 25%;
                }
            </style>
        @endif

    </head>
    <body>
        <div id="menu">
            <a href="{{ url('') }}">
                <div class="menuel" style="border-top-left-radius:6px;">Home</div></a>
            <a href="{{ url('database') }}">
                <div class="menuel" >Database</div></a>
            <a href="{{ url('search') }}">
                <div class="menuel" >Search</div></a>
        @if(isset(auth()->user()->admin) && auth()->user()->admin)
            <a href = "{{ url('users') }}">
                <div class="menuel">Users</div></a>
        @endif

            <form method="POST" action="{{ route('logout') }}" class="home_back">
            @csrf
                <a href="#" onClick="this.parentNode.submit()">
                    <div class="menuel" style="border-top-right-radius: 8px; ">Logout</div>
                </a>
            </form> 

        </div>
        @yield('content')
    </body>
</html>