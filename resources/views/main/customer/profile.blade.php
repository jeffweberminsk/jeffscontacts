@extends('layouts.customer')

@section('title')
    Jeffscontacts Account
@endsection

@section('description')
@php
    $description = "Find work email, personal email, office phone, mobile phone and other contact information.";
    echo $description;
@endphp
@endsection

@section('view')
<div style="margin: 20px;">
    <h2>Profile</h2>
    <form action="" style="
    display: flex;
    flex-direction: column;
    ">
        <label for="first_name">First name</label>
        <input type="text" name="first_name" id="first_name" value="{{ Auth::guard('customer')->user()->first_name }}" disabled>
        <label for="last_name">Last name</label>
        <input type="text" name="first_name" id="last_name" value="{{ Auth::guard('customer')->user()->last_name }}" disabled>
        <label for="company">Company</label>
        <input type="text" name="first_name" id="company" value="{{ Auth::guard('customer')->user()->company }}" disabled>
    </form>
</div>


@endsection