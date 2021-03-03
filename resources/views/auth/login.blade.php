@extends('layouts.layout')

@section('content')
    <div class="login">
        <div class="container">
            <div class="login_title">Log In</div>
            <div class="login_body">
                <div class="login_wrapper">
                    <form method="POST" action="{{ route('login') }}" class="login_panel">
                        @csrf
                        <div class="login_items">
                            <label for="email" class="login_name">Email</label>
                            <input id="email" type="email" class="login_name @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
    
                            <label for="password" class="login_password">Password</label>
                            <input id="password" type="password" class="login_password @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="login_checkbox">
                            <label for="remember" class="checkbox_title">Remember Me</label>
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        </div>
                        <div class="login_buttons">
                            <button type="submit" class="login_button">Enter</button>                          
                        </div>
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>                    
                    </form> 
                </div>
            </div>         
        </div>
    </div>
@endsection