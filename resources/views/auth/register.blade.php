<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>jeffcontacts.com</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="login">
            <div class="container">
                <div class="login_title">Register</div>
                <div class="login_body">
                    <div class="login_wrapper">
                        <form method="POST" action="{{ route('register') }}" class="login_panel">
                            @csrf
                            <div class="login_items">
                                <label for="email" class="login_name">Email</label>
                                <input id="email" type="email" class="login_name @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        
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

                                <label for="password-confirm" class="login_password">Password confirm</label>
                                <input id="password-confirm" type="password" class="login_password @error('password') is-invalid @enderror" name="password_confirmation" required>
        
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label for="first_name" class="login_name">First name</label>
                                <input id="first_name" type="text" class="login_name @error('email') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}"  required autocomplete="first_name">
        
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label for="last_name" class="login_name">Last name</label>
                                <input id="last_name" type="text" class="login_name @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"  required autocomplete="last_name">
        
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        

                                <label for="company" class="login_name">Company</label>
                                <input id="company" type="text" class="login_name @error('company') is-invalid @enderror" name="company" value="{{ old('company') }}"  required autocomplete="company">
        
                                @error('company')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="login_buttons">
                                <button type="submit" class="login_button">Register</button>                          
                            </div>
                        </form> 
                    </div>
                </div>         
            </div>
        </div>
    </body>
</html>
