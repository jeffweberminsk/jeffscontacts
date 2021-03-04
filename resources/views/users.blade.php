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
        @isset($users)
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                    <input type="checkbox" name="admin"
                        @if($user->admin == 1)
                            checked
                        @endif                   
                        disabled/>
                        </td>
                    <td>
                            <a href="{{ url('users/'.$user->id) }}">  <button style="color:#333;" class="btn" onclick="return(userremove());">Edit</button></a>
                            <a href="{{ url('users/remove/'.$user->id) }}">  <button style="color:#333;" class="btn" onclick="return(userremove());">Remove</button></a>
                    </td>
                </tr>
            @endforeach
        @endisset
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href="{{ url('users/add') }}"><button style="color:#333;" class="btn">New user</button></a></td>
                </tr>
        </table>
</div>

<script type="text/javascript">

    function userremove()
    {
        var r=confirm("Do you want to remove this user?")
        if (r==true)
            return true;
        else
            return false;
    }

</script>
@endsection