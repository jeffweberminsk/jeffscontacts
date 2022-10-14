@extends('layouts.customer')

@section('title')
    Settings
@endsection

@section('description')
@php
    $description = "Find work email, personal email, office phone, mobile phone and other contact information.";
    echo $description;
@endphp
@endsection

@section('view')
<h2>Settings</h2>
@endsection