<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <title>Admin for JDB</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
        <script type="text/javascript" src="{{ asset('assets/js/jquery-2.1.1.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/bootstrap.js') }}"></script>

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
            <a href = "{{ url('employees') }}">
                <div class="menuel">Employees</div></a>
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