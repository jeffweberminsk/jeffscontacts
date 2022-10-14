@extends('layouts.admin')

@section('content')
<div id="contact">
    <div id="contacttext" style="padding-bottom: 10%;">

        <h3>Welcome {{ auth()->user()->first_name }} {{ auth()->user()->last_name  }}</h3>
        @if(auth()->user()->admin)
            <h4>
                Your status: Admin
            </h4>
        @else
            <h4>
                Your can: look  
                @if(auth()->user()->edit) edit @endif 
                @if(auth()->user()->create) create duplicate @endif
                @if(auth()->user()->remove) delete @endif
            </h4>
        @endif     
        @if(auth()->user()->edit || auth()->user()->create)
        <a href = "{{ url('company') }}">
            <div class="btn btn-sm ">Edit companies</div>
        </a>
        <a href = "{{ url('jeffcode') }}">
            <div class="btn btn-sm ">Edit jeffcodes</div>
        </a>
        <a href = "{{ url('job_title') }}">
            <div class="btn btn-sm ">Edit job titles</div>
        </a>
        @endif
    </div>
</div>
@endsection
