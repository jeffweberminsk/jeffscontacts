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
                <div class="login_title">Reset password</div>
                <div class="login_body">
                    <div class="login_wrapper">
                    <form method="POST" action="{{ route('password.update') }}" >
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
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
                        <button type="submit" class="login_button">Reset password</button>                          
                    </form> 
                    </div>
                </div>         
            </div>
        </div>
    </body>
</html>
