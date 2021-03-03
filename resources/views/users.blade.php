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
                        @if ($user->admin == 1)
                            checked
                        @endif                   
                        disabled/>
                        </td>
                    <td>
                        <a href="">    <button style="color:#333;" class="btn">Edit</button></a>
                        <a href="">  <button style="color:#333;" class="btn" onclick="return(userremove());">Remove</button></a>
                    </td>
                </tr>
            @endforeach
        @endisset
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><button class="btn" onclick="location.href='add user'">New user</button></td>
                </tr>
        </table>
</div>
@endsection