@extends('layouts.admin')

@section('content')
<div id="mainuserdiv">
@if (isset($user))
    <div id="userformtoptext"><h3>Edit user {{ $user->first_name }} {{ $user->last_name }}</h3></div>
    <form method="POST" action="{{ url('users/'.$user->id) }}" class="signin_panel">
@else
    <div id="userformtoptext"><h3>Create a new user</h3></div>
    <form method="POST" action="{{ url('users/add') }}" class="signin_panel">
@endif

        @csrf 
        <input type="email" name="email" id="email" class="form-control"
               placeholder="Username (E-mail)" tabindex="1"
               value="{{ $user->email ?? ''}}"><br>                        

        
        <input type="text" name="first_name" id="first_name" class="form-control"
               placeholder="First Name" tabindex="2"
               value="{{ $user->first_name ?? ''}}"><br>


        <input type="text" name="last_name" id="last_name" class="form-control"
               placeholder="Last Name" tabindex="3"
               value="{{ $user->last_name ?? ''}}"><br>

        <input type="password" name="password" id="password" class="form-control"
               placeholder="Password" tabindex="4"
               value=""><br>


       <input id="password-confirm" type="password" name="password_confirmation" @empty($user) required @endempty autocomplete="new-password" class="form-control"
               placeholder="Confirm Password" tabindex="5"
               value=""></br> 


        <div align="center" style="font-size:17px;">Permissions on contacts</div>
        <table class="table" style="text-align:center;">
        <tr>
            <td>Add new</td>
            <td>Edit</td>
            <td>Remove</td>
        </tr>
        <tr>
            <td><input type="checkbox" name="create"
            @if(isset($user) && $user->create == 1)
                checked
            @endif    ></td>
            <td><input type="checkbox" name="edit"
            @if(isset($user) && $user->edit == 1)
                checked
            @endif    ></td>
            <td><input type="checkbox" name="remove"
            @if(isset($user) && $user->remove == 1)
                checked
            @endif    ></td>
        </tr>
        </table>

        <div align="center" style="font-size:17px;">Or</div>

        <div class="checkbox" align="center">
            <label>
                <input type="checkbox" name="admin"
                @if(isset($user) && $user->admin == 1)
                    checked
                @endif    > Check to set up <b>admin</b> features.
            </label>
            </br>
            Admin automatically gets all permissions turned on.</br>
        </div></br>

        <input class="btn" type="submit" onclick="return(useredit());" value="Save">
        <a href="{{ url('/users') }}"><input class="btn" type="button" value="Cancel" style="float:right; color: #333;"></a>
    </form>
</div> 

<script type="text/javascript">

    function useredit()
    {
        @if (isset($user))
            var r=confirm("Do you want to edit this user?")
        @else
            var r=confirm("Do you want to add this user?")
        @endif
        if (r==true)
            return true;
        else
            return false;
    }
    
</script>

@endsection