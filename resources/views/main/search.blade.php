@extends('layouts.app')

@section('title')
    Jeffscontacts
@endsection

@section('description')
@php
    $description = "Find work email, personal email, office phone, mobile phone and other contact information.";
    echo $description;
@endphp
@endsection

@section('content')
<div class="container">
<div class="row">
  <!-- BEGIN SEARCH RESULT -->
  <div class="col-md-12">
    <div class="grid search">
      <div class="grid-body">
        <div class="row">
        <form id="form" role="form" action="{{ url('search/') }}" method="get"></form>
          <!-- BEGIN FILTERS -->
          <div class="col-md-3">
            <h2 class="grid-title"><i class="fa fa-filter"></i> Filters</h2>
            <hr>
            
            <!-- BEGIN FILTER-->
            <h4>Job Title:</h4>            
            <input form="form" id="job" type="text" name="job" class="form-control" placeholder="Job Title" value="{{ app('request')->input('job') ?? ''}}">
            <h4>Company:</h4>            
            <input form="form" id="company" type="text" name="company" class="form-control" placeholder="Company" value="{{ app('request')->input('company') ?? ''}}">
            <h4>City:</h4>            
            <input form="form" id="city" type="text" name="city" class="form-control" placeholder="City" value="{{ app('request')->input('city') ?? ''}}">
            <h4>Country:</h4>            
            <input form="form" id="country" type="text" name="country" class="form-control" placeholder="Country" value="{{ app('request')->input('country') ?? ''}}">
            <h4>Jeffcodes:</h4>
            <div>
                <span id="codes_area" style="float:left;width:69%;"> 
                @if (null !== (app('request')->input('jeffcodes')))
                    @foreach(app('request')->input('jeffcodes') as $contac_jeffcode)
                        <div>
                        <select form="form" name="jeffcodes[]" id="jeffcodes" class="form-control input-sm">
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
            <!-- <input form="form" id="jeffcode" type="text" name="jeffcode" class="form-control" placeholder="Jeffcode" value="{{ app('request')->input('jeffcode') ?? ''}}">
            END FILTER-->
            <br>
            <button class="btn btn-danger btn-lg btn-block" type="button" onclick="ClearFields();">Clear</button>   
            <br>
            <button class="btn btn-primary btn-lg btn-block" type="button" onclick="SaveSelection();">Save selection</button>      
          </div>
          <!-- END FILTERS -->

          <!-- BEGIN RESULT -->
          <div class="col-md-9">
            <h2><i class="fa fa-file-o"></i> Result</h2>
            <hr>
            <!-- BEGIN SEARCH INPUT -->
            <div class="input-group">
              <input form="form" id="name"  type="text" class="form-control" placeholder="name" name="name">
                <button class="btn btn-primary" type="submit" form="form"><i class="fa fa-search"></i></button>

            </div>
            @isset($results)
            <!-- END SEARCH INPUT -->
            @if(app('request')->input('name'))
              <p>Showing all results matching "{{app('request')->input('name')}}"</p>
            @endif
    
            <div class="padding"></div>

            <!-- BEGIN TABLE RESULT -->
            <div class="table-responsive">
              <table class="table table-hover">
                <tbody>
                @if (count($results))
                @php
                    $i=($results->currentPage()-1)*20;
                @endphp
                @foreach($results as $result)
                    @php
                      $i++;
                    @endphp
                    <tr>
                        <td class="number text-center">{{ $i}}</td>
                        <td> <input type="checkbox" name="selection" value="{{ $result->id }}"> </td>
                        <td class="image"><img src="{{ Storage::url($result->photo) }}" alt="{{ ($result->fullname) }}"></td>
                        <td>{{ $result->first_name ?? ''}}</td>
                        <td>{{ $result->last_name ?? ''}}</td>
                        <td>{{ $result->sub_company ?? $result->main_company ?? ''}}</td>
                        <td>
                        @isset($result->work_email)
                            <i>Work: </i>{{ $result->work_email }}<br>
                        @endisset
                        @isset($result->personal_email)
                            <i>Personal: </i>{{ $result->personal_email }}<br>
                        @endisset
                        </td>
                        <td style="width: 25%;">
                            <a href="{{ url('contact/'.$result->slug) }}">  <button class="btn btn-sm search-button">Go to Contact</button></a>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <div style="text-align: center; margin-bottom: 28.65%;">
                        <h3>No results</h3>
                    </div>
                </tr>
                @endif
              </tbody></table>
            </div>
            <!-- END TABLE RESULT -->

            <!-- BEGIN PAGINATION -->
            <div style="width:100%;">
              <div style="float:left;">{{ $results->appends($input)->links('employee.custom') ?? ''}}</div>
            </div>
            <!-- END PAGINATION -->
            @endisset
          </div>
          <!-- END RESULT -->

        </div>
      </div>
    </div>
  </div>
  <!-- END SEARCH RESULT -->
</div>
</div>

<dialog id="favDialog">
  <form method="dialog">
    <p><label>Select list:
      <select id="listSelector">
        @foreach(Auth::guard('customer')->user()->lists()->get() as $list)
          <option value='{{ $list->name }}'>{{ $list->name }}</option>        
        @endforeach
      </select>
    </label></p>
    <menu>
      <button value="cancel">Cancel</button>
      <button id="confirmBtn" value="submit">Confirm</button>
    </menu>
  </form>
</dialog>


<script>
function addCode(){
    var selectList = '<div class="rjc"><select form="form" name="jeffcodes[]" id="jeffcodes" class="form-control input-sm">';
    @foreach($jeffcodes as $jeffcode)
        selectList += "<option value='{{ $jeffcode->id }}'"
         +">{{ $jeffcode->jeffcode }}</option>";         
    @endforeach
    selectList += "</select>"+
    "<button type='button' class='btn btn-danger' onclick='$(this).parent().remove();'>Remove</button>"+
    "</div>";
    jQuery('#codes_area').append(selectList);
}

function ClearFields(){    
    $("input").each(function(){
        $(this).val('');
    });
    $('#codes_area').empty();
}

function getCheckedBoxes(chkboxName) {
  var checkboxes = document.getElementsByName(chkboxName);
  var checkboxesChecked = [];
  for (var i=0; i<checkboxes.length; i++) {
     if (checkboxes[i].checked) {
        checkboxesChecked.push(checkboxes[i].value);
     }
  }
  return checkboxesChecked.length > 0 ? checkboxesChecked : null;
}

var favDialog = document.getElementById('favDialog');
var selection;
function SaveSelection(){    
  selection = getCheckedBoxes('selection');
  if (!selection){
    alert('empty selection');
    return;
  }
  if (typeof favDialog.showModal === "function") {
    favDialog.showModal();
  } else {
    alert("The <dialog> API is not supported by this browser");
  }
}

favDialog.addEventListener('close', function onClose() {
  httpRequest = new XMLHttpRequest();
  if (favDialog.returnValue === 'cancel')
    return;
  if (!httpRequest) {
    alert('Cannot create an XMLHTTP instance');
    return false;
  }
  httpRequest.onreadystatechange = alertContents;
  httpRequest.open("POST", "{{ url('customer/addTolist') }}", true);
  httpRequest.setRequestHeader('Content-Type', 'application/json');
  httpRequest.send(JSON.stringify({
      _token: '{{ csrf_token() }}',
      list: document.getElementById('listSelector').value,
      contacts: selection
  }));
});
    
function alertContents() {
  if (httpRequest.readyState === XMLHttpRequest.DONE) {
    if (httpRequest.status === 200) {
      alert('Saved');
    } else {
      alert('There was a problem with the request.');
    }
  }
}
/*
function addContact(checkbox,conatct_id){
  //alert( auth()->user()->id );
  if($(checkbox).is(":checked")){
    $.ajax({
        type:'GET',
        url:"{{ url('user/addconact/')}}/"+conatct_id,
        //data: {},
        success:function(data) {
          //$(checkbox).prop('checked', true);
        },
        error:function(data) {
          $(checkbox).prop('checked', false);
        }
    })
  }else{
    $.ajax({
        type:'GET',
        url:"{{ url('user/removeconact/')}}/"+conatct_id,
        //data: {},
        success:function(data) {
          //$(checkbox).prop('checked', true);
        },
        error:function(data) {
          $(checkbox).prop('checked', false);
        }
    })
  }
}
*/
</script>
@endsection