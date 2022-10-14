@extends('layouts.admin')

@section('content')
<div id="userstable">
    <div>
        <table class="table">
               <tr style="
                   font-size: 15px;
                    font-weight: bold;
                    color: rgba(45, 110, 163, 0.95);
               ">
                   <td>First Name</td>
                   <td>Last Name</td>
                   <td>Email (Username)</td>
                   <td>Admin</td>
                   <td>Action</td>
               </tr>
        @isset($employees)
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->first_name }}</td>
                    <td>{{ $employee->last_name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>
                    <input type="checkbox" name="admin"
                        @if($employee->admin == 1)
                            checked
                        @endif                   
                        disabled/>
                        </td>
                    <td>
                            <a href="{{ url('employees/'.$employee->id) }}">  <button style="color:#333;" class="btn">Edit</button></a>
                            <a href="{{ url('employees/remove/'.$employee->id) }}">  <button style="color:#333;" class="btn" onclick="return(employeeremove());">Remove</button></a>
                    </td>
                </tr>
            @endforeach
        @endisset
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href="{{ url('employees/add') }}"><button style="color:#333;" class="btn">New employee</button></a></td>
                </tr>
        </table>
</div>

<script type="text/javascript">

    function employeeremove()
    {
        var r=confirm("Do you want to remove this employee?")
        if (r==true)
            return true;
        else
            return false;
    }

</script>
@endsection