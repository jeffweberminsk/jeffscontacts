<<<<<<< HEAD
@extends('layouts.admin')

@section('content')
<div id="contact">
    <div id="contacttext" style="padding-bottom: 10%;">

        <h3>Welcome {{ $name_first ?? '' }} {{ $name_last ?? ''  }},"</h3>
        @isset($admin)
            <h4>
                Your status: Admin
            </h4>
        @endisset
        <br>
        <h4>Notes:</h4><br>
        <form role="form" action="home/note" method="post" >
            <textarea rows="12" class="form-control" name="note" placeholder="Everyone can leave note here">
                {{ $notes ?? ''}}
            </textarea>
            <br>
            <div id="freeowtestas"><input class="btn" style="color:#333333;" type="submit" value="Save Notes"></div>
        </form>
    </div>
</div>

=======
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
>>>>>>> 5014665681b0dda70ab60ddd13e1be6bfbd52192
@endsection