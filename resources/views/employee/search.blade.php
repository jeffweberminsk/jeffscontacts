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
                <input name="ready" type="radio" value="0"                         
                        @if(!app('request')->input('ready'))
                            checked
                        @endif/> All contacts<br>
                <input name="ready" type="radio" value="1"                         
                        @if(app('request')->input('ready') == 1)
                            checked
                        @endif/> Not ready for jeffscontacts.com<br>
                <input name="ready" type="radio" value="2"                         
                        @if(app('request')->input('ready') == 2)
                            checked
                        @endif/>  Ready for jeffscontacts.com
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
                <input id="search" style="width:100%;" class="btn search-button-big" type="submit" value="Search" onclick="fillall()"><br><br>
        </form>
                <a href="{{ url('search/dup_names') }}">
                    <button id="turn_loader_names" type="button" style="width: 100%" class="btn search-button-big disabled">Name duplicates</button>
                    </a><br><br>

                <a href="{{ url('search/csv') }}">
                    <button type="button" style="width: 100%" class="btn search-button-big disabled">Generate CSV</button>
                </a>

            </div>
    </div>

    @if (count($results))
    <div id="searchtable" class="col-lg-10 col-md-10 col-sm-10">
       <div style="width:100%;">
            <div style="float:left;">{{ $results->links('employee.custom') }}</div>
            <div class="menuel" style="float:left; margin: 15px 20px; color: #428BCA; text-align: left; background-color: white; border-left: 0px; border-right: 0px; white-space: nowrap">Total found: {{ $results->total() }}</div>
        </div>
        

        <table class="table table-condensed" style="float:left;">
            <tr style="
                        font-size: 15px;
                            font-weight: bold;
                            color: rgba(45, 110, 163, 0.95);
                    ">
                <td>ID</td>
                <td style="white-space: nowrap;">First Name</td>
                <td style="white-space: nowrap;">Last Name</td>
                <td style="white-space: nowrap;">Company</td>
                <td style="white-space: nowrap;">Email</td>
                <td style="width: 25%;">Action</td>

            </tr>
        @foreach($results as $result)
            <tr>
                <td>{{ $result->id}}</td>
                <td>{{ $result->first_name ?? ''}}</td>
                <td>{{ $result->last_name ?? ''}}</td>
                <td>{{ $result->company ?? ''}}</td>
                <td>
                   @isset($result->work_email)
                    <i>Work: </i>{{ $result->work_email }}<br>
                   @endisset
                   @isset($result->personal_email)
                    <i>Personal: </i>{{ $result->personal_email }}<br>
                   @endisset
                </td>
                <td style="width: 25%;">
                    <a href="{{ url('database/'.$result->id) }}">  <button class="btn btn-sm search-button">Go to Contact</button></a>
                </td>
            </tr>
        @endforeach
        </table>
    </div>

    @else
        <div style="text-align: center; margin-bottom: 28.65%; color:rgba(45, 110, 163, 0.95);">
            <h3>No results</h3>
        </div>
    @endif

@endsection