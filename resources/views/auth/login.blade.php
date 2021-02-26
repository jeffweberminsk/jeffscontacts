@extends('layouts.layout')

@section('content')
    <div class="login">
        <div class="container">
            <div class="login_header">Log In</div>
            <div class="login_body">
                <form action="POST" class="login_panel">
                    <div class="login_items">
                        <label class="login_name">Name</label>
                        <input type="text" class="login_name">
                        <label class="login_password">Password</label>
                        <input type="password" class="login__password">
                    </div>
                    <div class="login_buttons">
                        <button class="login_button-enter">Enter</button>
                        <button class="login_button-signin">Sign In</button>
                        <button class="login_button-exit">Back</button>
                    </div>
                </form>
            </div> 
             
        </div>
    </div>
@endsection