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

@endsection