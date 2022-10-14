@extends('layouts.admin')

@section('content')
<div id="mainuserdiv">
@if (isset($employee))
    <div id="userformtoptext"><h3>Edit employee {{ $employee->first_name }} {{ $employee->last_name }}</h3></div>
    <form method="POST" action="{{ url('employees/'.$employee->id) }}" class="signin_panel">
@else
    <div id="userformtoptext"><h3>Create a new employee</h3></div>
    <form method="POST" action="{{ url('employees/add') }}" class="signin_panel">
@endif

        @csrf 
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="email" name="email" id="email" class="form-control"
               placeholder="Username (E-mail)" tabindex="1"
               value="{{ $employee->email ?? old('email')}}"><br>                        

        @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="text" name="first_name" id="first_name" class="form-control"
               placeholder="First Name" tabindex="2"
               value="{{ $employee->first_name ?? old('first_name') }}"><br>



        @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="text" name="last_name" id="last_name" class="form-control"
               placeholder="Last Name" tabindex="3"
               value="{{ $employee->last_name ?? old('last_name')}}"><br>

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="text" name="password" id="password" class="form-control"
               placeholder="Password" tabindex="4"
               value=""><br>


        <input id="password-confirm" type="text" name="password_confirmation" autocomplete="new-password" class="form-control"
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
            @if($employee->create ?? old('create'))
                checked
            @endif    ></td>
            <td><input type="checkbox" name="edit"
            @if($employee->edit ?? old('edit'))
                checked
            @endif    ></td>
            <td><input type="checkbox" name="remove"
            @if($employee->remove ?? old('remove'))
                checked
            @endif    ></td>
        </tr>
        </table>

        <div align="center" style="font-size:17px;">Or</div>

        <div class="checkbox" align="center">
            <label>
                <input type="checkbox" name="admin"
                @if($employee->admin ?? old('admin'))
                    checked
                @endif    > Check to set up <b>admin</b> features.
            </label>
            </br>
            Admin automatically gets all permissions turned on.</br>
        </div></br>

        <input class="btn" type="submit" onclick="return(employee_edit());" value="Save">
        <a href="{{ url('/employees') }}"><input class="btn" type="button" value="Cancel" style="float:right; color: #333;"></a>
    </form>
</div> 

<script type="text/javascript">

    function employee_edit()
    {
        @if (isset($employee))
            var r=confirm("Do you want to edit this employee?")
        @else
            var r=confirm("Do you want to add this employee?")
        @endif
        if (r==true)
            return true;
        else
            return false;
    }
    
</script>

@endsection