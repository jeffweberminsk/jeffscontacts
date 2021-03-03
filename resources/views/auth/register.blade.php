@extends('layouts.admin')

@section('content')
<div id="mainuserdiv">
    <div id="userformtoptext"><h3>Create a new user</h3></div>
    <form method="POST" action="{{ route('register') }}" class="signin_panel">
        @csrf 
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
               placeholder="Username (E-mail)" tabindex="1"
               value="{{ old('email') }}"><br>                        
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        
        <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror"
               placeholder="First Name" tabindex="2"
               value="{{ old('first_name') }}"><br>
        @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror"
               placeholder="Last Name" tabindex="3"
               value="{{ old('last_name') }}"><br>
        @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
               placeholder="Password" tabindex="4"
               value="{{ old('password') }}"><br>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror

       <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control"
               placeholder="Confirm Password" tabindex="5"
               value="{{ old('password') }}"></br> 


        <div align="center" style="font-size:17px;">Permissions on contacts</div>
        <table class="table" style="text-align:center;">
        <tr>
            <td>Add new</td>
            <td>Edit</td>
            <td>Remove</td>
        </tr>
        <tr>
            <td><input type="checkbox" name="create"></td>
            <td><input type="checkbox" name="edit"></td>
            <td><input type="checkbox" name="remove"></td>
        </tr>
        </table>

        <div align="center" style="font-size:17px;">Or</div>

        <div class="checkbox" align="center">
            <label>
                <input type="checkbox" name="admin"> Check to set up <b>admin</b> features.
            </label>
            </br>
            Admin automatically gets all permissions turned on.</br>
        </div></br>

        <input class="btn" type="submit" value="Create user">
        <a href="{{ url('/users') }}"><input class="btn" type="button" value="Cancel" style="float:right; color: #333;"></a>
    </form>
</div>     
@endsection