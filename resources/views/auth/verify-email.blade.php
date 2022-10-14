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
                <div class="login_title">Verify email</div>
                <div class="login_body">
                    <div class="login_wrapper">
                    <form method="POST" action="{{ route('verification.send') }}" >
                    @csrf
                        <button type="submit" class="login_button">ReSend</button>                          
                    </form> 
                    </div>
                </div>         
            </div>
        </div>
    </body>
</html>
