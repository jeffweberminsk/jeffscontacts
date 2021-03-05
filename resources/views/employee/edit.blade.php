
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
                        value="{{ $contact->first_name ?? old('first_name') }}">
                </td>
            </tr>
            <tr>
                <td>Last Name: </td>
                <td>
                    <input type="text" name="last_name" id="last_name" class="form-control input-sm" tabindex="3"
                        value="{{ $contact->last_name ?? old('last_name') }}">
                </td>
            </tr>
            <tr>
                <td>Job Title: </td>
                <td>
                    <input type="text" name="job" id="job" class="form-control input-sm" tabindex="4"
                        value="{{ $contact->job ?? old('job') }}">
                </td>
            </tr>
            <tr>
                <td>Company: </td>
                <td>
                    <input type="text" name="company" id="company" class="form-control input-sm" tabindex="10"
                        value="{{ $contact->company ?? old('company') }}">
                </td>
            </tr>
            <tr>
                <td>City:</td>
                <td>
                    <input type="text" name="city" id="city" class="form-control input-sm" tabindex="16"
                        value="{{ $contact->city ?? old('city') }}">
                </td>
            </tr>
            <tr>
                <td>State:</td>
                <td>
                    <input list="states" type="text" name="state" id="state" class="form-control input-sm" tabindex="16"
                        value="{{ $contact->state ?? old('state') }}">
                    <datalist id="states">  
                        <!--us states-->                      
                        <option value="Alabama">
                        <option value="Alaska">
                        <option value="Arizona">
                        <option value="California">
                        <option value="Colorado">
                        <option value="Delaware">
                        <option value="Florida">
                        <option value="Georgia">
                        <option value="Hawaii">
                        <option value="Idaho">
                        <option value="Illinois">
                        <option value="Indiana">
                        <option value="Iowa">
                        <option value="Kansas">
                        <option value="Kentucky">
                        <option value="Louisiana">
                        <option value="Maine">
                        <option value="Maryland">
                        <option value="Massachusetts">
                        <option value="Michigan">
                        <option value="Minnesota">
                        <option value="Mississippi">
                        <option value="Missouri">
                        <option value="Montana">
                        <option value="Nebraska">
                        <option value="Nevada">
                        <option value="New Hampshire">
                        <option value="New Jersey">
                        <option value="New Jersey">
                        <option value="New Mexico">
                        <option value="New York">
                        <option value="North Carolina">
                        <option value="North Dakota">
                        <option value="Ohio">
                        <option value="Oklahoma">
                        <option value="Oregon">
                        <option value="Pennsylvania">
                        <option value="Rhode Island">
                        <option value="South Carolina">
                        <option value="South Dakota">
                        <option value="Tennessee">
                        <option value="Texas">
                        <option value="Utah">
                        <option value="Vermont">
                        <option value="Virginia">
                        <option value="Washington">
                        <option value="West Virginia">
                        <option value="Wisconsin">
                        <option value="Wyoming">

                        <!--canadian states-->
                        <option value="Alberta">
                        <option value="British Columbia ">
                        <option value="Manitoba">
                        <option value="New Brunswick">
                        <option value="Newfoundland">
                        <option value="Nova Scotia">
                        <option value="Ontario">
                        <option value="Prince Edward Island">
                        <option value="Quebec">
                        <option value="Saskatchewan">
                    </datalist>                    
                </td>
            </tr>
            <tr>
                <td>Country:</td>
                <td>   
                    <input list="countries" type="text" name="country" id="country" class="form-control input-sm" tabindex="16"
                            value="{{ $contact->country ?? old('country') }}">  
                    <datalist id="countries">                        
                        <option value="Australia">
                        <option value="Brazil">
                        <option value="Canada">
                        <option value="Eqypt">
                        <option value="Iraq">
                        <option value="Edge">
                        <option value="Kazakhstan">
                        <option value="Kuwait">
                        <option value="Malaysia">
                        <option value="Mexico">
                        <option value="Netherlands">
                        <option value="Nigeria">
                        <option value="Norway">
                        <option value="Oman">
                        <option value="Qatar">
                        <option value="Russian Federation">
                        <option value="Saudi Arabia">
                        <option value="Singapore">
                        <option value="United Arab Emirates">
                        <option value="United Kingdom">
                        <option value="United States">
                    </datalist>
                </td>
            </tr>
            <tr>
                <td>Company Phone: </td>
                <td>
                    <input type="text" name="office_phone" id="office_phone" class="form-control input-sm" tabindex="13"
                        value="{{ $contact->office_phone ?? old('office_phone') }}">
                </td>
            </tr>
            <tr>
                <td>Direct phone: </td>
                <td>
                    <input type="text" name="direct_phone" id="direct_phone" class="form-control input-sm" tabindex="9"
                        value="{{ $contact->direct_phone ?? old('direct_phone') }}">
                    @error('direct_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror    
                </td>
            </tr>
            <tr>
                <td>Mobile phone Nr.1: </td>
                <td>
                    <input type="text" name="mobile_phone_a" id="mobile_phone_a" class="form-control input-sm" tabindex="7"
                        value="{{ $contact->mobile_phone_a ?? old('mobile_phone_a') }}">
                    @error('mobile_phone_a')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror                   
                </td>
            </tr>
            <tr>
                <td>Mobile phone Nr.2: </td>
                <td>
                    <input type="text" name="mobile_phone_b" id="mobile_phone_b" class="form-control input-sm" tabindex="8"
                        value="{{ $contact->mobile_phone_b ?? old('mobile_phone_b') }}">
                    @error('mobile_phone_b')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror                    
                </td>
            </tr>
            <tr>
                <td>Work E-mail: </td>
                <td>
                    <span style="float:left;width:69%;">
                        <input type="email" name="work_email" id="work_email" class="form-control input-sm" tabindex="5"
                            value="{{ $contact->work_email ??  old('work_email') }}"></span>
                    <div id="work_js_verify" class="btn btn-sm verify-button disabled">Verify Email</div>
                    @error('work_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>Personal E-mail: </td>
                <td>
                    <span style="float:left;width:69%;"><input type="email" name="personal_email" id="personal_email" class="form-control input-sm" tabindex="6"
                        value="{{ $contact->personal_email ?? old('personal_email') }}"></span>
                    <div id="personal_js_verify" class="btn btn-sm verify-button disabled">Verify Email</div>
                    @error('personal_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror               
                </td>
            </tr>
            <tr>
                <td>Linkedin url </td>
                <td>
                    <input type="text" name="li" id="li" class="form-control input-sm" tabindex="8"
                        value="{{ $contact->li ?? old('li') }}">
                    @error('li')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror    
                </td>
            </tr>
            <tr>
                <td>Jeffcode: </td>
                <td>
                    <input type="text" name="jeffcode" id="jeffcode" class="form-control input-sm" tabindex="8"
                        value="{{ $contact->jeffcode ?? old('jeffcode') }}">
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
                        id="ready"
                        @if (isset($contact->ready) && $contact->ready == 1)
                            checked
                        @endif                   
                        /><br>
                    <input tabindex="21"
                        type="checkbox"
                        name="buyer"
                        id="buyer"
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
                            value="">{{ $contact->notes ?? old('notes') }}</textarea>

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
            <div id="conbtnfirst" class="conbtn" onclick="return(condup());">Duplicate </div>           
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

function conremove(){
    @if(auth()->user()->remove)
        var r=confirm("Do you want to remove this contact?");
        if (r==true)
            return true;
        else
            return false;
    @else
        var r=confirm("You're not allowed to remove records")
        return false;
    @endif

}

function condup(){    
    @if(auth()->user()->create)
        var r=confirm("Do you want to duplicate this contact?");
        if (r==true){
            $('#first_name').val('');
            $('#last_name').val('');
            $('#job').val('');
            $('#direct_phone').val('');
            $('#mobile_phone_a').val('');
            $('#mobile_phone_b').val('');
            $('#work_email').val('');
            $('#personal_email').val('');
            $('#li').val('');
            $('#jeffcode').val('');
            $('#ready').prop( "checked", false );
            $('#buyer').prop( "checked", false );
            $('#notes').val('');
            $('#contact_edit_from').attr('action', "{{ url('database/add')}}");
            $( "#contact_edit_from" ).submit();
        }
        else
            return false;
    @else
        var r=confirm("You're not allowed to duplicate records")
        return false;
    @endif
}

@if (isset($contact))
    function contactedit(){
        @if(auth()->user()->edit)
            var r=confirm("Do you want to edit this contact?");
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
                var url = 'http://'+thisurl+'/database/'+id;
                window.location = url;
            }else{
                alert('Please type Ad ID correctly.');
            }
    });

@else
    function addcont(){
        @if(auth()->user()->create)
            var r=confirm("Do you want to add this contact?");
            if (r==true)
                return true;
            else
                return false;
        @else
            var r=confirm("You're not allowed to add records")
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