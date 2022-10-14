<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        
        <title>@yield('title')</title>
        <meta charset="utf-8">
        <meta name="description" content="@yield('description')">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="{{ asset('css/example.css') }}" rel="stylesheet">

    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
                <a class="navbar-brand" href="{{ url('/') }}">
                  <img src="logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
                  Jeffscontacts
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/plans') }}">Price</a>
                    </li>
                    @if(Auth::guard('customer')->user())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/customer') }}">Account</a>
                    </li>
                    @endif
                </ul>                
                <div class="nav navbar-nav navbar-right">
                    @if(Auth::guard('customer')->user())
                        <form method="POST" action="{{ route('logout') }}" class="home_back">
                        @csrf
                            <a href="#" onClick="this.parentNode.submit()">
                                <button class="btn btn-outline-danger" type="button">Logout</button>
                            </a>
                        </form> 
                    @else
                        <a href="{{ route('login') }}">
                            <button class="btn btn-outline-success" type="button">Log in</button>
                        </a>
                        <a href="{{ route('register') }}">
                            <button class="btn btn-outline-success" type="button">Free trial</button>
                        </a>
                    @endif
                </div>

              </nav>
        </header>

        @yield('content')

        <footer class="bg-light text-center text-lg-start">
            <div>
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                    © 2020 Copyright:
                    <a class="text-dark" href="#">jeffscontacts.com</a>
                  </div>
            </div>
        </footer>   

    </body>
 
</html>