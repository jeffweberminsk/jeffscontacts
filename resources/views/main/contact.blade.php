@extends('layouts.app')

@section('title')
@php
    echo $contact->description." phone, email"
@endphp
@endsection

@section('description')
@php
    $description = "Get contact information for $contact->description. Email address. Phone.";
    echo $description;
@endphp
@endsection

@section('content')
<div class="container">
<table class="table table-condensed" id="contacts_table">
    @isset($contact->first_name)
    <tr>
        <td>First Name: </td>
        <td>
            <input readonly type="text" name="first_name" id="first_name" class="form-control input-sm" tabindex="1"
                value="{{ $contact->first_name ?? old('first_name') }}">
        </td>
    </tr>
    @endisset

    @isset($contact->last_name)
    <tr>
        <td>Last Name: </td>
        <td>
            <input readonly type="text" name="last_name" id="last_name" class="form-control input-sm" tabindex="2"
                value="{{ $contact->last_name }}">
        </td>
    </tr>
    @endisset

    @isset($contact->job)
    <tr>
        <td>Job Title: </td>
        <td>
            <input readonly type="text" name="job" id="job" class="form-control input-sm" tabindex="3"
                value="{{ $contact->job }}">
        </td>
    </tr>
    @endisset

    @isset($contact->main_company)
    <tr>
        <td>Company: </td>
        <td>
            <input readonly type="text" name="company" id="company" class="form-control input-sm" tabindex="4"
                value="{{ $contact->main_company }}">
        </td>
    </tr>            
    @endisset

    @isset($contact->sub)
    <tr>
        <td>Sub Company: </td>
        <td>
            <input readonly type="text" name="sub_company" id="sub_company" class="form-control input-sm" tabindex="5"
                value="{{ $contact->sub }}">
        </td>
    </tr>
    @endisset

    @isset($contact->city)
    <tr>
        <td>City:</td>
        <td>
            <input readonly type="text" name="city" id="city" class="form-control input-sm" tabindex="6"
                value="{{ $contact->city }}">
        </td>
    </tr>
    @endisset

    @isset($contact->state)
    <tr>
        <td>State:</td>
        <td>
            <input readonly type="text" name="state" id="state" class="form-control input-sm" tabindex="7"
            value="{{ $contact->state }}">
        </td>
    </tr>
    @endisset

    @isset($contact->country)
    <tr>
        <td>Country:</td>
        <td>   
            <input readonly list="countries" type="text" name="country" id="country" class="form-control input-sm" tabindex="8"
                    value="{{ $contact->country }}">  
        </td>
    </tr>
    @endisset

    @isset($contact->office_phone)
    <tr>
        <td>Company Phone: </td>
        <td>
            <input readonly type="text" name="office_phone" id="office_phone" class="form-control input-sm" tabindex="9"
                value="{{ $contact->office_phone }}">
        </td>
    </tr>
    @endisset

    @isset($contact->direct_phone)
    <tr>
        <td>Direct phone: </td>
        <td>
            <input readonly type="text" name="direct_phone" id="direct_phone" class="form-control input-sm" tabindex="10"
                value="{{ $contact->direct_phone }}">
        </td>
    </tr>
    @endisset

    @isset($contact->mobile_phone_a)
    <tr>
        <td>Mobile phone Nr.1: </td>
        <td>
            <input readonly type="text" name="mobile_phone_a" id="mobile_phone_a" class="form-control input-sm" tabindex="11"
                value="{{ $contact->mobile_phone_a }}">            
        </td>
    </tr>
    @endisset

    @isset($contact->mobile_phone_b)
    <tr>
        <td>Mobile phone Nr.2: </td>
        <td>
            <input readonly type="text" name="mobile_phone_b" id="mobile_phone_b" class="form-control input-sm" tabindex="12"
                value="{{ $contact->mobile_phone_b }}">               
        </td>
    </tr>
    @endisset

    @isset($contact->work_email)
    <tr>
        <td>Work E-mail: </td>
        <td>
            <input readonly type="email" name="work_email" id="work_email" class="form-control input-sm" tabindex="13"
                value="{{ $contact->work_email }}">

        </td>
    </tr>
    @endisset

    @isset($contact->personal_email)
    <tr>
        <td>Personal E-mail: </td>
        <td>
            <input readonly type="email" name="personal_email" id="personal_email" class="form-control input-sm" tabindex="14"
                value="{{ $contact->personal_email }}">       
        </td>
    </tr>
    @endisset
</table>

<button id="addButton" type="button"
@if (Auth::guard('customer')->user() && Auth::guard('customer')->user()->has_contact($contact->id))
 style="display: none;"
@endif  
>Add to Contacts</button>

<button id="removeButton" type="button"
@if (Auth::guard('customer')->user() && !Auth::guard('customer')->user()->has_contact($contact->id))
 style="display: none;"
@endif  
>Remove from Contacts</button>
</div>

<script>
    (function() {
      var httpRequest;
      var add;
      document.getElementById("addButton").addEventListener('click', addRequest);
      document.getElementById("removeButton").addEventListener('click', removeRequest);

      function addRequest() {
        httpRequest = new XMLHttpRequest();
    
        if (!httpRequest) {
          alert('Cannot create an XMLHTTP instance');
          return false;
        }
        httpRequest.onreadystatechange = alertContents;
        add = true;
        httpRequest.open('GET', "{{ url('customer/addconact/').'/'.$contact->id }}");
        httpRequest.responseType = "json";
        httpRequest.send();
      }

      function removeRequest() {
        httpRequest = new XMLHttpRequest();
    
        if (!httpRequest) {
          alert('Cannot create an XMLHTTP instance');
          return false;
        }
        httpRequest.onreadystatechange = alertContents;
        add = false;
        httpRequest.open('GET', "{{ url('customer/removeconact/').'/'.$contact->id }}");
        httpRequest.responseType = "json";
        httpRequest.send();
      }
    
      function alertContents() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
          if (httpRequest.status === 200) {
            alert(httpRequest.response.message);
            if (add){
                document.getElementById("addButton").style.display = "none";
                document.getElementById("removeButton").style.display = "";
            }else{
                document.getElementById("addButton").style.display = "";
                document.getElementById("removeButton").style.display = "none";
            } 
          } else {
            alert('There was a problem with the request.');
          }
        }
      }
    })();
</script>
@endsection