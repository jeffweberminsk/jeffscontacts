@extends('layouts.layout')

@section('content')
    <h1 class="home_title">Welcome <span>{{ auth()->user()->login }}</span> !</h1>
    <div class="home_body">
        <div class="home_wrapper">
            <img src="{{ asset('icons/home.svg') }}" alt="home" class="home_icon">
            <div class="home_subtitle">Home</div>
        </div>
        <div class="home_description">This home page is under construction to demonstrate registration capabilities and other features. The information at the top of the page indicates successful login. The designs, like the page itself, are not final. To leave this page, please click on the button below.</div>
        <form method="POST" action="{{ route('logout') }}" class="home_back">
            @csrf
            <button class="home_button">Sig Out</button>
        </form> 
    </div>
    <div class="footer">
        <div class="footer_description">Jeff's Contacts (v.0.0.1)</div>
    </div>
@endsection