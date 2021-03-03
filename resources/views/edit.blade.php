
@extends('layouts.admin')

@section('content')
<div id="contact_main">
@if (isset($contact))
    <form id="contact_edit_from" role="form" action="{{ url('database/'.$contact->id) }}" method="post">
@else
    <form id="contact_edit_from" role="form" action="{{ url('database/add')}}" method="post">
@endif
@csrf
    <div id="contact">
        <div id="contacttext">
        @if (isset($contact))
            <h4>Contact Information (ID:{{ $contact->id }})</h4>
        @else
            <h4>Create a  contact</h4>
        @endif
        </div>
        <table class="table table-condensed" id="contacts_table">
            <tr>
                <td>First Name: </td>
                <td>
                    <input type="text" name="first_name" id="first_name" class="form-control input-sm" tabindex="1"
                        value="{{ $contact->first_name ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>Last Name: </td>
                <td>
                    <input type="text" name="last_name" id="last_name" class="form-control input-sm" tabindex="3"
                        value="{{ $contact->last_name ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>Job Title: </td>
                <td>
                    <input type="text" name="job" id="job" class="form-control input-sm" tabindex="4"
                        value="{{ $contact->job ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>Company: </td>
                <td>
                    <input type="text" name="company" id="company" class="form-control input-sm" tabindex="10"
                        value="{{ $contact->company ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>City:</td>
                <td>
                    <input type="text" name="city" id="city" class="form-control input-sm" tabindex="16"
                        value="{{ $contact->city ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>State:</td>
                <td>
                    <input type="text" name="state" id="state" class="form-control input-sm" tabindex="16"
                        value="{{ $contact->state ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>Country:</td>
                <td>   
                    <input type="text" name="country" id="country" class="form-control input-sm" tabindex="16"
                            value="{{ $contact->country ?? ''}}">  
                </td>
            </tr>
            <tr>
                <td>Company Phone: </td>
                <td>
                    <input type="text" name="office_phone" id="office_phone" class="form-control input-sm" tabindex="13"
                        value="{{ $contact->office_phone ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>Direct phone: </td>
                <td>
                    <input type="text" name="direct_phone" id="direct_phone" class="form-control input-sm" tabindex="9"
                        value="{{ $contact->direct_phone ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>Mobile phone Nr.1: </td>
                <td>
                    <input type="text" name="mobile_phone_a" id="mobile_phone_a" class="form-control input-sm" tabindex="7"
                        value="{{ $contact->mobile_phone_a ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>Mobile phone Nr.2: </td>
                <td>
                    <input type="text" name="mobile_phone_b" id="mobile_phone_b" class="form-control input-sm" tabindex="8"
                        value="{{ $contact->mobile_phone_b ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>Work E-mail: </td>
                <td>
                    <span style="float:left;width:69%;">
                        <input type="email" name="work_email" id="work_email" class="form-control input-sm" tabindex="5"
                            value="{{ $contact->work_email ?? ''}}"></span>
                    <div id="work_js_verify" class="btn btn-sm verify-button">Verify Email</div>
                </td>
            </tr>
            <tr>
                <td>Personal E-mail: </td>
                <td>
                    <span style="float:left;width:69%;"><input type="email" name="personal_email" id="personal_email" class="form-control input-sm" tabindex="6"
                        value="{{ $contact->personal_email ?? ''}}"></span>
                    <div id="personal_js_verify" class="btn btn-sm verify-button">Verify Email</div>
                </td>
            </tr>
            <tr>
                <td>Linkedin url </td>
                <td>
                    <input type="text" name="li" id="li" class="form-control input-sm" tabindex="8"
                        value="{{ $contact->li ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>Jeffcode: </td>
                <td>
                    <input type="text" name="jeffcode" id="jeffcode" class="form-control input-sm" tabindex="8"
                        value="{{ $contact->jeffcode ?? ''}}">
                </td>
            </tr>
            <tr>
                <td>
                    Ready for jeffscontacts.com:<br>
                    Buyer for jeffscontacts.com:
                </td>
                <td>
                    <input tabindex="20"
                        type="checkbox"
                        name="ready"
                        @if (isset($contact->ready) && $contact->ready == 1)
                            checked
                        @endif                   
                        /><br>
                    <input tabindex="21"
                        type="checkbox"
                        name="buyer"
                        @if (isset($contact->buyer) && $contact->buyer == 1)
                            checked
                        @endif                   
                        /><br>
                </td>
            </tr>
            <tr>
                <td>Notes: </td>
                <td>
                    <textarea rows="4" name="notes" id="notes" class="form-control input-sm" tabindex="23"
                            value="">{{ $contact->notes ?? ''}}</textarea>

                </td>
            </tr>
            <tr>
                <td>Last review date: </td>
                <td>                
                    <input id="last_check"  type="date" class="form-control input-sm" name="last_check" 
                    value="{{ $contact->last_check ?? ''}}" readonly>
                </td>
            </tr>
        </table>
    </div>

    <div id="buttons_main">
        <div id="buttons">
        @if (isset($contact))
            <a href="{{ url('database/add') }}"><div id="conbtnfirst" class="conbtnfirst">Add new </div>  </a>
            <div id="conbtnfirst" class="conbtn" onclick="return(contactedit());">Save changes </div>
            <a href="{{ url('database/remove/'.$contact->id) }}"><div id="conbtnfirst" class="conbtn" onclick="return(conremove());">Remove</div> </a>
            <a href="{{ url('database/dup/'.$contact->id) }}"><div id="conbtnfirst" class="conbtn" onclick="return(condup());">Duplicate</div> </a>
            
            <div>
                <a href="{{url('database/'.$contact->id).'/previous'}}"><div id="rleft" class="routescl conbtn"><span class="glyphicon glyphicon-chevron-left"></span></div></a>
                <div id="rcenter" class="conbtn routescl">Go contact</div>
                <a href="{{url('database/'.$contact->id).'/next'}}"><div id="rright" class="routescl conbtn"><span class="glyphicon glyphicon-chevron-right"></span></div></a>
            </div>

            <div id="conbtnlast" style="border-bottom-left-radius:5px;">
                    <div id="goto" >
                        <div id="inputdiv">
                            <input type="text" name="conid" id="conid" class="form-control" placeholder="Contact ID">
                        </div>
                        <div id="goto_contact">
                        <div style="width:25%;float:left;">Goto
                        </div>
                        <div style="float:left; width:15%; text-align:left;">
                            <div class="glyphicon glyphicon-chevron-right"></div>
                        </div>
                        </div>
                    </div>
            </div>
        @else
            <input id="conbtnfirst" type="submit" value="Add new contact" onclick="return(addcont());">

            <a href="{{ url(url()->previous()) }}">  <div id="conbtnfirst" style="border-bottom-left-radius:7px;">Cancel / Back</div>   </a>
        @endif
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('assets/js/jquery-2.1.1.js') }}"></script>
<script>

@if (isset($contact))
    function contactedit(){
        @if(auth()->user()->edit)
            var r=confirm("Do you want to edit this contact?")
            if (r==true)
                $( "#contact_edit_from" ).submit();
            else
                return false;
        @else
            var r=confirm("You're not allowed to edit records")
            return false;
        @endif
    }

    $("#goto_contact").click(function(){
            var id = $("#conid").val();
            if($.isNumeric(id)){
                $("#loader").show();
                var thisurl = window.location.hostname;
                var url = 'http://'+thisurl+'/'+id;
                window.location = url;
            }else{
                alert('Please type Ad ID correctly.');
            }
    });
@else
    function addcont(){
        @if(auth()->user()->remove)
            var r=confirm("Do you want to add this contact?")
            if (r==true)
                return true;
            else
                return false;
        @else
            var r=confirm("You're not allowed to remove records")
            return false;
        @endif
    }
@endif


    document.getElementById("work_js_verify").onclick = function() {verify_email()};

    document.getElementById("personal_js_verify").onclick = function() {verify_personal_email()};

    function verify_email() {

        var email = document.getElementById("email_work").value;

        if(email){
            var thisurl = window.location.hostname;
            var url = 'http://'+thisurl+'/index.php/contact/verify_email_js/'+email;
            var win = window.open(url, '_blank');
            win.focus();
        }else{
            alert('Please type email first.');
        }
    }

    function verify_personal_email() {

        var email = document.getElementById("email_personal").value;

        if(email){
            var thisurl = window.location.hostname;
            var url = 'http://'+thisurl+'/index.php/contact/verify_email_js/'+email;
            var win = window.open(url, '_blank');
            win.focus();
        }else{
            alert('Please type email first.');
        }
    }

</script>
@endsection
