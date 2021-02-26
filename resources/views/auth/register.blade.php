@extends('layouts.layout')

@section('content')
    <div class="signin">
        <div class="container">
            <div class="signin_header">Sign In</div>
            <div class="signin_body">
                <form method="POST" action="{{ route('register') }}" class="signin_panel">

                    @csrf 

                    <div class="signin_items">
                        <label class="signin_login">Name</label>
                        <input id ="login" type="text" class="signin_login @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus>
                        
                        {{--Работает ли это правильно?--}}
                        @error('login')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <label class="signin_email">Email</label>
                        <input id="email" type="email" class="signin_email @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        
                        {{--Работает ли это правильно?--}}
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <label class="signin_password">Password</label>
                        <input id="password" type="password" class="signin_password @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        
                        {{--Работает ли это правильно?--}}
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="signin_confirm_password">Confirm Password</div>
                        <input id="password-confirm" type="password" class="signin_confirm_password" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="signin_buttons">
                        <button type="submit" class="signin_button-enter">Enter</button>
                        <button class="signin_button-login">Log In</button>
                        <button class="signin_button-exit">Back</button>
                    </div>
                    <div class="signin_checkbox">
                        <label for="admin" class="checkbox_title">admin</label>
                        <input type="checkbox" id="admin" name="admin">
                        <label for="edit" class="checkbox_title">edit</label>
                        <input type="checkbox" id="edit" name="edit">
                        <label for="create" class="checkbox_title">create</label>
                        <input type="checkbox" id="create" name="create">
                        <label for="remove" class="checkbox_title">remove</label>
                        <input type="checkbox" id="remove" name="remove">
                    </div>
                </form>
            </div> 
        </div>
    </div>
@endsection