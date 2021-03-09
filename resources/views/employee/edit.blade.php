
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
                    <input type="text" name="last_name" id="last_name" class="form-control input-sm" tabindex="2"
                        value="{{ $contact->last_name ?? old('last_name') }}">
                </td>
            </tr>
            <tr>
                <td>Job Title: </td>
                <td>
                    <input type="text" name="job" id="job" class="form-control input-sm" tabindex="3"
                        value="{{ $contact->job ?? old('job') }}">
                </td>
            </tr>
            <tr>
                <td>Company: </td>
                <td>
                    <input type="text" name="company" id="company" class="form-control input-sm" tabindex="4"
                        value="{{ $contact->company ?? old('company') }}">
                </td>
            </tr>
            <tr>
                <td>City:</td>
                <td>
                    <input type="text" name="city" id="city" class="form-control input-sm" tabindex="5"
                        value="{{ $contact->city ?? old('city') }}">
                </td>
            </tr>
            <tr>
                <td>State:</td>
                <td>
 <!--                   <input list="states" type="text" name="state" id="state" class="form-control input-sm" tabindex="6"
                        value="{{ $contact->state ?? old('state') }}"> -->
                        <select for="contact_edit_from" name="state" id="states" class="form-control input-sm" tabindex="6" >
                        @php
                            if(isset($contact->state))
                                $state = $contact->state;
                            else
                                $state = 'no';
                        @endphp
                        <option></option>
                        <!--us states--> 
                        <optgroup id="us" label="US States">
                            <option value="Alabama" @if($state == "Alabama") selected @endif>Alabama</option>
                            <option value="Alaska" @if($state == "Alaska") selected @endif>Alaska</option>
                            <option value="Arizona" @if($state == "Arizona") selected @endif>Arizona</option>
                            <option value="California" @if($state == "California") selected @endif>California</option>
                            <option value="Colorado" @if($state == "Colorado") selected @endif>Colorado</option>
                            <option value="Delaware" @if($state == "Delaware") selected @endif>Delaware</option>
                            <option value="Florida" @if($state == "Florida") selected @endif>Florida</option>
                            <option value="Georgia" @if($state == "Georgia") selected @endif>Georgia</option>
                            <option value="Hawaii" @if($state == "Hawaii") selected @endif>Hawaii</option>
                            <option value="Idaho" @if($state == "Idaho") selected @endif>Idaho</option>
                            <option value="Illinois" @if($state == "Illinois") selected @endif>Illinois</option>
                            <option value="Indiana" @if($state == "Indiana") selected @endif>Indiana</option>
                            <option value="Iowa" @if($state == "Iowa") selected @endif>Iowa</option>
                            <option value="Kansas" @if($state == "Kansas") selected @endif>Kansas</option>
                            <option value="Kentucky" @if($state == "Kentucky") selected @endif>Kentucky</option>
                            <option value="Louisiana" @if($state == "Louisiana") selected @endif>Louisiana</option>
                            <option value="Maine" @if($state == "Maine") selected @endif>Maine</option>
                            <option value="Maryland" @if($state == "Maryland") selected @endif>Maryland</option>
                            <option value="Massachusetts" @if($state == "Massachusetts") selected @endif>Massachusetts</option>
                            <option value="Michigan" @if($state == "Michigan") selected @endif>Michigan</option>
                            <option value="Minnesota" @if($state == "Minnesota") selected @endif>Minnesota</option>
                            <option value="Mississippi" @if($state == "Mississippi") selected @endif>Mississippi</option>
                            <option value="Missouri" @if($state == "Missouri") selected @endif>Missouri</option>
                            <option value="Montana" @if($state == "Montana") selected @endif>Montana</option>
                            <option value="Nebraska" @if($state == "Nebraska") selected @endif>Nebraska</option>
                            <option value="Nevada" @if($state == "Nevada") selected @endif>Nevada</option>
                            <option value="New Hampshire" @if($state == "New Hampshire") selected @endif>New Hampshire</option>
                            <option value="New Jersey" @if($state == "New Jersey") selected @endif>New Jersey</option>
                            <option value="New Mexico" @if($state == "New Mexico") selected @endif>New Jersey</option>
                            <option value="New York" @if($state == "New York") selected @endif>New York</option>
                            <option value="North Carolina" @if($state == "North Carolina") selected @endif>North Carolina</option>
                            <option value="North Dakota" @if($state == "North Dakota") selected @endif>North Dakota</option>
                            <option value="Ohio" @if($state == "Ohio") selected @endif>Ohio</option>
                            <option value="Oklahoma" @if($state == "Oklahoma") selected @endif>Oklahoma</option>
                            <option value="Oregon" @if($state == "Oregon") selected @endif>Oregon</option>
                            <option value="Pennsylvania" @if($state == "Pennsylvania") selected @endif>Pennsylvania</option>
                            <option value="Rhode Island" @if($state == "Rhode Island") selected @endif>Rhode Island</option>
                            <option value="South Carolina" @if($state == "South Carolina") selected @endif>South Carolina</option>
                            <option value="South Dakota" @if($state == "South Dakota") selected @endif>South Dakota</option>
                            <option value="Tennessee" @if($state == "Tennessee") selected @endif>Tennessee</option>
                            <option value="Texas" @if($state == "Texas") selected @endif>Texas</option>
                            <option value="Utah" @if($state == "Utah") selected @endif>Utah</option>
                            <option value="Vermont" @if($state == "Vermont") selected @endif>Vermont</option>
                            <option value="Virginia" @if($state == "Virginia") selected @endif>Virginia</option>
                            <option value="Washington" @if($state == "Washington") selected @endif>Washington</option>
                            <option value="West Virginia" @if($state == "West Virginia") selected @endif>West Virginia</option>
                            <option value="Wisconsin" @if($state == "Wisconsin") selected @endif>Wisconsin</option>
                            <option value="Wyoming" @if($state == "Wyoming") selected @endif>Wyoming</option>
                        </optgroup>                 

                        <!--canadian states-->
                        <optgroup id="canada" label="Canadian States">
                            <option value="Alberta" @if($state == "Alberta") selected @endif >Alberta</option>
                            <option value="British Columbia" @if($state == "British Columbia") selected @endif>British Columbia</option>
                            <option value="Manitoba" @if($state == "Manitoba") selected @endif>Manitoba</option>
                            <option value="New Brunswick" @if($state == "New Brunswick") selected @endif>New Brunswick</option>
                            <option value="Newfoundland" @if($state == "Newfoundland") selected @endif>Newfoundland</option>
                            <option value="Nova Scotia" @if($state == "Nova Scotia") selected @endif>Nova Scotia</option>
                            <option value="Ontario" @if($state == "Ontario") selected @endif>Ontario</option>
                            <option value="Prince Edward Island" @if($state == "Prince Edward Island") selected @endif>Prince Edward Island</option>
                            <option value="Quebec" @if($state == "Quebec") selected @endif>Quebec</option>
                            <option value="Saskatchewan" @if($state == "Saskatchewan") selected @endif>Saskatchewan</option>
                        </optgroup>

                    </select>  
                  
                </td>
            </tr>
            <tr>
                <td>Country:</td>
                <td>   
                    <input list="countries" type="text" name="country" id="country" class="form-control input-sm" tabindex="7"
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
                    <input type="text" name="office_phone" id="office_phone" class="form-control input-sm" tabindex="8"
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
                    <input type="text" name="mobile_phone_a" id="mobile_phone_a" class="form-control input-sm" tabindex="10"
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
                    <input type="text" name="mobile_phone_b" id="mobile_phone_b" class="form-control input-sm" tabindex="11"
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
                        <input type="email" name="work_email" id="work_email" class="form-control input-sm" tabindex="12"
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
                    <span style="float:left;width:69%;"><input type="email" name="personal_email" id="personal_email" class="form-control input-sm" tabindex="13"
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
                    <input type="text" name="li" id="li" class="form-control input-sm" tabindex="14"
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
                    <input type="text" name="jeffcode" id="jeffcode" class="form-control input-sm" tabindex="15"
                        value="{{ $contact->jeffcode ?? old('jeffcode') }}">
                </td>
            </tr>
            <tr>
                <td>
                    Ready for jeffscontacts.com:<br>
                    Buyer for jeffscontacts.com:
                </td>
                <td>
                    <input tabindex="16"
                        type="checkbox"
                        name="ready"
                        id="ready"
                        @if ($contact->ready ?? old('ready'))
                            checked
                        @endif                   
                        /><br>
                    <input tabindex="17"
                        type="checkbox"
                        name="buyer"
                        id="buyer"
                        @if ($contact->buyer ?? old('buyer'))
                            checked
                        @endif                   
                        /><br>
                </td>
            </tr>
            <tr>
                <td>Notes: </td>
                <td>
                    <textarea rows="4" name="notes" id="notes" class="form-control input-sm" tabindex="18"
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

$('#states').on('change', function() {
    var selected = $("option:selected", this);
    switch (selected.parent()[0].id ) {
    case 'us':
        $('#country').val("United States");
        break;
    case 'canada':
        $('#country').val("Canada");
        break;
    }
});

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
