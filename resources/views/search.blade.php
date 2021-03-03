@extends('layouts.admin')

@section('content')
    <div id="searchmain">
        <form role="form" action="{{ url('search/') }}" method="get">
            <div class="col-lg-offset-1 col-sm-3 col-md-3 col-lg-3">
                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ app('request')->input('first_name') ?? ''}}">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ app('request')->input('last_name') ?? ''}}">
                <input id="comm" type="text" name="company" class="form-control" placeholder="Company" value="{{ app('request')->input('company') ?? ''}}">
                <input id="email" type="text" name="email" class="form-control" placeholder="E-mail" value="{{ app('request')->input('email') ?? ''}}">
            </div>
            <div class="col-sm-3 col-md-3 col-lg-2">
                <input name="id_from" type="text" class="form-control" placeholder="From ID" value="{{ app('request')->input('id_from') ?? ''}}">
                <input name="id_to" type="text" class="form-control" placeholder="To ID" value="{{ app('request')->input('id_to') ?? ''}}">
            </div>
            <div class="col-sm-3 col-md-3 col-lg-2">
                <input name="ready_for_jc" type="radio" value="0"                         
                        @isset($search->all)
                            checked
                        @endisset/> All contacts<br>
                <input name="ready_for_jc" type="radio" value="1"                         
                        @isset($search->not)
                            checked
                        @endisset/> Not ready for jeffscontacts.com<br>
                <input name="ready_for_jc" type="radio" value="2"                         
                        @isset($search->ready)
                            checked
                        @endisset/>  Ready for jeffscontacts.com
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
                <input id="search" style="width:100%;" class="btn search-button-big" type="submit" value="Search" onclick="fillall()"><br><br>
        </form>
                <a href="{{ url('search/dup_names') }}"><button id="turn_loader_names" type="button" style="width: 100%" class="btn search-button-big">Name duplicates</button></a><br><br>
                <a href="{{ url('search/dup_emails') }}"><button id="turn_loader_emails" type="button" style="width: 100%" class="btn search-button-big">E-mail duplicates</button></a><br><br>

            @isset($search_state){
                if(!empty($_GET['ready_for_jc'])){
                    $ready = $_GET['ready_for_jc'];
                }else{
                    $ready = 0;
                }
            @endisset

                <a href="{{ url('search/csv') }}">
                    <button type="button" style="width: 100%" class="btn search-button-big disabled">Generate CSV</button>
                </a>

            </div>
    </div>
    @if (count($results))
        <h4>Contact Information (ID:{{ $contact->id }})</h4>
    @else
        <div style="text-align: center; margin-bottom: 28.65%; color:rgba(45, 110, 163, 0.95);">
            <h3>No results</h3>
        </div>
    @endif
@endsection