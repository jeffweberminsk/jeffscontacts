@extends('layouts.app')


@section('content')

<div style="
    display: flex;
">
    <div>
        <h1>Account</h1>
        <ul id="menu" style="background-color: white;">
            <li>
                <a href="{{ url('/customer/profile') }}">My Profile</a>
            </li>
            <li>
                <a href="{{ url('/customer/contacts') }}">My Contacts</a>
            </li>
            <li>
                <a href="{{ url('/customer/lists') }}">My Lists</a>
            </li>
            <li>
                <a href="{{ url('/customer/apps') }}">Connected Apps</a>
            </li>
            <li>
                <a href="{{ url('/customer/settings') }}">Settings</a>
            </li>
            <li>
                <a href="{{ url('/customer/plan') }}">Plan</a>
            </li>
        </ul> 
    </div>
    <div>
        @yield('view')
    </div>
</div>

@endsection
