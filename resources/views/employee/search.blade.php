@extends('layouts.admin')

@section('content')
    <div id="searchmain">
        <form id="contac_search_form" role="form" action="{{ url('search/') }}" method="get">
            <div class="col-lg-offset-1 col-sm-3 col-md-3 col-lg-3">
                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ app('request')->input('first_name') ?? ''}}">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{ app('request')->input('last_name') ?? ''}}">
                <input id="job" list="jobs_list" type="text" name="job"  class="form-control " placeholder="Job Title" value="{{ app('request')->input('job') ?? '' }}" autocomplete="nope">
                <input id="comm" type="text" name="company" class="form-control" placeholder="Company" value="{{ app('request')->input('company') ?? ''}}">
                <input id="email" type="text" name="email" class="form-control" placeholder="E-mail" value="{{ app('request')->input('email') ?? ''}}">
                <br>
                <div>
                    <span id="codes_area" style="float:left;width:69%;"> 
                    @if (null !== (app('request')->input('jeffcodes')))
                        @foreach(app('request')->input('jeffcodes') as $contac_jeffcode)
                            <div>
                            <select for="contact_edit_from" name="jeffcodes[]" id="jeffcodes" class="form-control input-sm">
                            @foreach($jeffcodes as $jeffcode)
                                <option value='{{ $jeffcode->id }}' @if($jeffcode->id == $contac_jeffcode) selected @endif'>{{ $jeffcode->jeffcode }}</option>
                            @endforeach
                            </select>
                            <button type='button' class='btn btn-danger' onclick='$(this).parent().remove();'>Remove</button>
                            </div>
                        @endforeach  
                    @endif
                    </span>
                    <div id="add_jeffcode" onclick="addCode();" class="btn btn-sm verify-button" tabindex="16">Add Code</div>

                </div>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-2">
                <input name="id_from" type="text" class="form-control" placeholder="From ID" value="{{ app('request')->input('id_from') ?? ''}}">
                <input name="id_to" type="text" class="form-control" placeholder="To ID" value="{{ app('request')->input('id_to') ?? ''}}">
                <br>
                <input id="orderN" name="order" type="radio" value="0"                         
                        @if(!app('request')->input('order'))
                            checked
                        @endif/><label for="orderN" style="font-weight:normal; padding-left: 2px; margin-bottom: 2px;">  Newer first</label><br>
                <input id="orderO" name="order" type="radio" value="1"                         
                        @if(app('request')->input('order') == 1)
                            checked
                        @endif/><label for="orderO" style="font-weight:normal; padding-left: 2px; margin-bottom: 2px;">  Older first</label><br>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-2">
                <input id="readyA" name="ready" type="radio" value="0"                         
                        @if(!app('request')->input('ready'))
                            checked
                        @endif/><label for="readyA" style="font-weight:normal; padding-left: 2px; margin-bottom: 2px;">All contacts</label><br>
                <input id="readyR" name="ready" type="radio" value="1"                         
                        @if(app('request')->input('ready') == 1)
                            checked
                        @endif/><label for="readyR" style="font-weight:normal; padding-left: 2px; margin-bottom: 2px;">Not ready for jeffscontacts.com</label><br>
                <input id="readyN" name="ready" type="radio" value="2"                         
                        @if(app('request')->input('ready') == 2)
                            checked
                        @endif/><label for="readyN" style="font-weight:normal; padding-left: 2px; margin-bottom: 2px;">Ready for jeffscontacts.com</label>
            </div>
            <div class="col-sm-3 col-md-3 col-lg-3">
                <input id="search" style="width:100%;" class="btn search-button-big" type="submit" value="Search"><br><br>
        </form>
                <a href="{{ url('search/null_names') }}">
                    <button id="null_names_btn" type="button" style="width: 100%" class="btn search-button-big">Empty contacts</button>
                </a><br><br>
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
            <div style="float:left;">{{ $results->appends($input)->links('employee.custom') }}</div>
            <div class="menuel" style="float:left; margin: 15px 20px; color: #428BCA; text-align: left; background-color: white; border-left: 0px; border-right: 0px; white-space: nowrap">Total found: {{ $results->total() }}</div>
        </div>
        

        <table class="table table-condensed" style="float:left;">
            <tr style="
                        font-size: 15px;
                            font-weight: bold;
                            color: rgba(45, 110, 163, 0.95);
                    ">
                <td style="white-space: nowrap;">First Name</td>
                <td style="white-space: nowrap;">Last Name</td>
                <td style="white-space: nowrap;">Company</td>
                <td style="white-space: nowrap;">Email</td>
                <td style="white-space: nowrap;">Last Checked</td>
                <td style="width: 25%;">Action</td>

            </tr>
        @foreach($results as $result)
            <tr>
                <td>{{ $result->first_name ?? ''}}</td>
                <td>{{ $result->last_name ?? ''}}</td>
                @if($result->main_company)
                <td>
                    <i>Main: </i>{{ $result->main_company }}<br>
                   @isset($result->sub_company)
                    <i>Sub: </i>{{ $result->sub_company }}<br>
                   @endisset
                </td>
                @elseif($result->old_sub || $result->old_main)
                <td>
                    @isset($result->old_main)
                    <i>Old main: </i>{{ $result->old_main }}<br>
                   @endisset
                   @isset($result->old_sub)
                    <i>Old sub: </i>{{ $result->old_sub }}<br>
                   @endisset
                </td>
                @else
                    <td></td>
                @endif
                <td>
                   @isset($result->work_email)
                    <i>Work: </i>{{ $result->work_email }}<br>
                   @endisset
                   @isset($result->personal_email)
                    <i>Personal: </i>{{ $result->personal_email }}<br>
                   @endisset
                </td>
                <td>{{ $result->last_check ?? ''}}</td>
                <td style="width: 25%;">
                    <button class="btn btn-sm search-button" onClick="goTo({{ $result->id }})">Go to Contact</button>
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

<script type="text/javascript" src="{{ asset('assets/js/jquery-2.1.1.js') }}"></script>
<script>
function addCode(){
    var selectList = '<div class="rjc"><select for="contact_edit_from" name="jeffcodes[]" id="jeffcodes" class="form-control input-sm">';
    @foreach($jeffcodes as $jeffcode)
        selectList += "<option value='{{ $jeffcode->id }}'"
         +">{{ $jeffcode->jeffcode }}</option>";         
    @endforeach
    selectList += "</select>"+
    "<button type='button' class='btn btn-danger' onclick='$(this).parent().remove();'>Remove</button>"+
    "</div>";
    jQuery('#codes_area').append(selectList);
}

function goTo(id){
    $('#contac_search_form').attr('action', "{{ url('search/list') }}/"+id);
    $( "#contac_search_form" ).submit();
}
</script>
@endsection