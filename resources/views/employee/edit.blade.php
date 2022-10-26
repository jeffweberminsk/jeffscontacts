
@extends('layouts.admin')

@section('content')

    <div id="contact_main">
        @if (isset($contact))
            <form id="contact_edit_from" role="form" action="{{ url('database/'.$contact->id) }}" method="post" enctype="multipart/form-data">
                @else
                    <form id="contact_edit_from" role="form" action="{{ url('database/add')}}" method="post" enctype="multipart/form-data">
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
                                    <td>
                                        <label for="photo">
                                            @if (isset($contact))
                                                <img id="profile" style="float:left; width: 128px; height: 128px;" src="{{ Storage::url($contact->photo) }}"/>
                                            @else
                                                <img id="profile" style="float:left; width: 128px; height: 128px;" src="{{ Storage::url('user.png')}}"/>
                                            @endif
                                            <input type='file' id="photo" name="photo" style="display:none" accept="image/*" />
                                        </label>
                                    </td>

                                </tr>
                                <tr>
                                    <td>First Name: </td>
                                    <td>
                                        <input type="text" name="first_name" id="first_name" class="form-control input-sm" tabindex="1"
                                               value="{{ $contact->first_name ?? old('first_name') }}" autocomplete="nope">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last Name: </td>
                                    <td>
                                        <input type="text" name="last_name" id="last_name" class="form-control input-sm" tabindex="2"
                                               value="{{ $contact->last_name ?? old('last_name') }}" autocomplete="nope">
                                        <div id="verify_name" onclick="verifyName();" class="btn btn-sm verify-button" style="width: 100%; margin-top: 5px;">Confirm contact is not already in jc.com</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Job Title: </td>
                                    <td>
                                        <input list="jobs_list" type="text" name="job" id="job" class="form-control input-sm" tabindex="3" value="{{$contact->new_job ?? $contact->job ?? old('job') }}" autocomplete="nope">
                                        <datalist id="jobs_list">
                                            @foreach($jobs as $job)
                                                <option value="{{ $job->job }}">
                                            @endforeach
                                        </datalist>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Company: </td>
                                    <td>
                                        <input list="companies_list" type="text" name="main_company" id="main_company" class="form-control input-sm" tabindex="4" value="{{ $contact->main_company ?? old('main_company') }}" autocomplete="nope">
                                        <datalist id="companies_list">
                                            @foreach($companies as $company)
                                                <option value="{{ $company->main_company }}">
                                            @endforeach
                                        </datalist>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sub Company: </td>
                                    <td>
                <span id="sub_select" style="float:left;width:69%;">
                <select for="contact_edit_from" name="company" id="company" class="form-control input-sm" tabindex="5" >
                    @if(!isset($sub_companies))
                        <option value=""></option>
                    @else
                        @foreach($sub_companies as $sub_company)
                            <option value="{{ $sub_company->sub_company }}" @if($sub_company->sub_company == $contact->sub) selected @endif> {{ $sub_company->sub_company }}</option>
                        @endforeach
                    @endif
                </select>
                </span>
                                        <div id="add_sub_company" onclick="addSub();" class="btn btn-sm verify-button">New</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>
                                        <input type="text" name="city" id="city" class="form-control input-sm" tabindex="5"
                                               value="{{ $contact->city ?? old('city') }}" style="float:left;width:69%;" autocomplete="nope">
                                        <button type="button" class="btn btn-sm verify-button" data-toggle="modal" data-target="#companyModal" data-company="{{ $company->id }}">Locations</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>State:</td>
                                    <td>
                                        <select for="contact_edit_from" name="state" id="states" class="form-control input-sm" tabindex="7" >
                                            @php
                                                if(isset($contact->state))
                                                    $state = $contact->state;
                                                else
                                                    $state = 'no';
                                            @endphp
                                            <option></option>
                                            <optgroup id="us" label="US States">
                                                <option value="Alabama" @if($state == "Alabama") selected @endif>Alabama</option>
                                                <option value="Alaska" @if($state == "Alaska") selected @endif>Alaska</option>
                                                <option value="Arizona" @if($state == "Arizona") selected @endif>Arizona</option>
                                                <option value="Arkansas" @if($state == "Arkansas") selected @endif>Arkansas</option>
                                                <option value="California" @if($state == "California") selected @endif>California</option>
                                                <option value="Colorado" @if($state == "Colorado") selected @endif>Colorado</option>
                                                <option value="Connecticut" @if($state == "Connecticut") selected @endif>Connecticut</option>
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
                                                <option value="New Mexico" @if($state == "New Mexico") selected @endif>New Mexico</option>
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
                                            <optgroup id="canada" label="Canadian Province">
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
                                            <optgroup id="australia" label="Australian States">
                                                <option value="New South Wales">New South Wales</option>
                                                <option value="Queensland">Queensland</option>
                                                <option value="South Australia">South Australia</option>
                                                <option value="Tasmania">Tasmania</option>
                                                <option value="Victoria">Victoria</option>
                                                <option value="Western Australia">Western Australia</option>
                                            </optgroup>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td>
                                        <input list="countries" type="text" name="country" id="country" class="form-control input-sm" tabindex="8"
                                               value="{{ $contact->country ?? old('country') }}" autocomplete="nope">
                                        <datalist id="countries">
                                            <option value="Australia">
                                            <option value="Brazil">
                                            <option value="Canada">
                                            <option value="Eqypt">
                                            <option value="Iraq">
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
                                    <td>Land phone pattern: </td>
                                    <td>
                                        <select id="phone_l_patterns" class="form-control input-sm "></select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Company Phone: </td>
                                    <td>
                                        <input type="text" name="office_phone" id="office_phone" class="form-control input-sm lphone" tabindex="9"
                                               value="{{ $contact->office_phone ?? old('office_phone') }}" autocomplete="nope">
                                        <datalist id="phone_l_patterns">
                                        </datalist>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Direct phone: </td>
                                    <td>
                                        <input type="tel" name="direct_phone" id="direct_phone" class="form-control input-sm lphone" tabindex="10"
                                               value="{{ $contact->direct_phone ?? old('direct_phone') }}" autocomplete="nope">
                                        @error('direct_phone')
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mobile phone pattern: </td>
                                    <td>
                                        <select id="phone_m_patterns" class="form-control input-sm " ></select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mobile phone Nr.1: </td>
                                    <td>
                                        <input list="phone_m_patterns" type="tel" name="mobile_phone_a" id="mobile_phone_a" class="form-control input-sm mphone" tabindex="11"
                                               value="{{ $contact->mobile_phone_a ?? old('mobile_phone_a') }}" autocomplete="nope">
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
                                        <input list="phone_m_patterns" type="tel" name="mobile_phone_b" id="mobile_phone_b" class="form-control input-sm mphone" tabindex="12"
                                               value="{{ $contact->mobile_phone_b ?? old('mobile_phone_b') }}" autocomplete="nope">
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
                                        <p id="email_pattern">{{ $contact->email_pattern  ?? 'no pattern' }}</p>
                                        <input type="email" name="work_email" id="work_email" class="form-control input-sm" tabindex="13"
                                               value="{{ $contact->work_email ??  old('work_email') }}" autocomplete="nope">
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
                                        <input type="email" name="personal_email" id="personal_email" class="form-control input-sm" tabindex="14"
                                               value="{{ $contact->personal_email ?? old('personal_email') }}" autocomplete="nope">
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
                                        <input type="text" name="li" id="li" class="form-control input-sm" tabindex="15"
                                               value="{{ $contact->li ?? old('li') }}" autocomplete="nope">
                                        @error('li')
                                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jeffscodes: </td>
                                    <td>
                    <span id="codes_area" style="float:left;width:69%;"> 
                    @if (isset($contact))
                            @foreach($contact->jeffcodes as $contac_jeffcode)
                                <div>
                            <select for="contact_edit_from" name="jeffcodes[]" class="jeffcodes form-control input-sm">
                            @foreach($jeffcodes as $jeffcode)
                                    <option value='{{ $jeffcode->id }}' @if($jeffcode->id == $contac_jeffcode->id) selected @endif'>{{ $jeffcode->jeffcode }}</option>
                                @endforeach
                            </select>
                            <button type='button' class='btn btn-danger' onclick='$(this).parent().remove();'>Remove</button>
                            </div>
                            @endforeach
                        @endif
                    </span>
                                        <div id="add_jeffcode" onclick="addCode();" class="btn btn-sm verify-button" tabindex="16">Add Code</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Ready for jc.com:<br>
                                        Buyer for jc.com:<br>
                                        Opted out:
                                    </td>
                                    <td>
                                        <input tabindex="17"
                                               type="checkbox"
                                               name="ready"
                                               id="ready"
                                               @if ($contact->ready ?? old('ready'))
                                                   checked
                                                @endif
                                        /><br>
                                        <input tabindex="18"
                                               type="checkbox"
                                               name="buyer"
                                               id="buyer"
                                               @if ($contact->buyer ?? old('buyer'))
                                                   checked
                                                @endif
                                        /><br>
                                        <input tabindex="19"
                                               type="checkbox"
                                               name="optedout"
                                               id="optedout"
                                               @if ($contact->optedout ?? old('optedout'))
                                                   checked
                                                @endif
                                        /><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact cost: </td>
                                    <td>
                                        <input type="number" name="cost" id="cost" class="form-control input-sm mphone" tabindex="20"
                                               value="{{ $contact->cost ?? old('cost') ?? 1}}" autocomplete="nope" min="1" max="5">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Notes: </td>
                                    <td>
                    <textarea rows="4" name="notes" id="notes" class="form-control input-sm" tabindex="21"
                              value="">{{ $contact->notes ?? old('notes') }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Last review date: </td>
                                    <td>
                <span style="float:left;width:50%;">
                    <input id="last_check"  type="date" class="form-control input-sm" name="last_check"
                           value="{{ $contact->last_check ?? ''}}" readonly>
                </span>
                                        <input style="width:50%;" id="who"  type="text" class="form-control input-sm" name="last_check"
                                               value="{{ $who_edited ?? 'not set'}}" readonly>
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
                                        @php
                                            function SetPrevious($contact) {
                                                if (session()->exists('list')){
                                                    $array = session('list');
                                                    if (count($array) < 2){
                                                        return $contact->id;
                                                    }
                                                    if($contact->id == $array[0]['id']){
                                                        return $array[count($array)-1]['id'];
                                                    }
                                                    for ($i = 1; $i < count($array);$i++){
                                                        if($contact->id == $array[$i]['id']){
                                                            return $array[$i-1]['id'];
                                                        }
                                                    }
                                                }else{
                                                    return $contact->id.'/previous';
                                                }
                                            }

                                            function SetNext($contact) {
                                                if (session()->exists('list')){
                                                    $array = session('list');
                                                    if (count($array) < 2){
                                                        return $contact->id;
                                                    }
                                                    if($contact->id == $array[count($array)-1]['id']){
                                                        return $array[0]['id'];
                                                    }
                                                    for ($i = 0; $i < count($array)-1;$i++){
                                                        if($contact->id == $array[$i]['id']){
                                                            return $array[$i+1]['id'];
                                                        }
                                                    }
                                                }else{
                                                    return $contact->id.'/next';
                                                }
                                            }

                                        $previous = SetPrevious($contact);
                                        $next = SetNext($contact)
                                        @endphp
                                        <a href="{{ url('database/'.$previous) }}"><div id="rleft" class="routescl conbtn"><span class="glyphicon glyphicon-chevron-left"></span></div></a>
                                        <div id="rcenter" class="conbtn routescl">Go contact</div>
                                        <a href="{{ url('database/'.$next) }}"><div id="rright" class="routescl conbtn"><span class="glyphicon glyphicon-chevron-right"></span></div></a>
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

    <div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="companyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">List of offices</h5>
                </div>
                <div class="modal-body">
                    <div style="margin-bottom: 5px;">
                        <input id="loc_search" type="text" name="loc_search" class="form-control input-sm" style="display: inline; width: 60%;">
                        <button type="button" name="down-btn" class="btn btn-primary" onclick="SearchDown();">&#9660;</button>
                        <button type="button" name="up-btn" class="btn btn-primary" onclick="SearchUp();">&#9650;</button>
                    </div>
                    <div id="officeList" style="max-height: 60vh; overflow:auto;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="officeForm" hidden>
        <div class="form-group" style="border-top: 1px solid grey;">
            <p style="margin-bottom: 0px; margin-top: 5px;" >Office type:</p>
            <input type="text" name="type" class="form-control input-sm" disabled>

            <p style="margin-bottom: 0px; margin-top: 5px;" >City:</p>
            <input type="text" name="city" class="form-control input-sm" disabled>

            <p style="margin-bottom: 0px; margin-top: 5px;" >State:</p>
            <input type="text" name="state" class="form-control input-sm" disabled>

            <p style="margin-bottom: 0px; margin-top: 5px;" >Country:</p>
            <input type="text" name="country" class="form-control input-sm" disabled>

            <p style="margin-bottom: 0px; margin-top: 5px;" >Company Phone:</p>
            <input type="text" name="office_phone" class="form-control input-sm" disabled>
            <button type='button' class='btn btn-primary' onclick='setOfficeData($(this).parent());'>Select</button>
        </div>
    </div>

    <script>

        $("#photo").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#profile').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        function verifyName(){
            $.ajax({
                type:'GET',
                url:"{{ url('search/verify')}}/",
                data: { first_name: $('#first_name').val(), last_name: $('#last_name').val() },
                success:function(data) {

                    if (!data.length){
                        alert('no matches')
                        return;
                    }
                    var result = "matches:\n"
                    data.forEach(function(match) {
                        if (match.first_name)
                            result += match.first_name+" ";
                        if (match.last_name)
                            result += match.last_name+" ";
                        if (match.sub){
                            result += "at "+match.sub+" ";
                        }else if(match.main_company){
                            result += "at "+match.main_company+" ";
                        }else if(match.sub_company){
                            result += "at "+match.sub_company+" ";
                        }else if(match.company){
                            result += "at "+match.company+" ";
                        }
                        result += "\n"
                    });
                    alert(result);
                }
            });
        }

        function verifyWorkEmail(){
            if (!$('#work_email').val()){
                alert("empty work email field");
                return;
            }
            $.ajax({
                type:'GET',
                url:"{{ url('/database/verifyEmail') }}",
                data: { email: $('#work_email').val() },
                success:function(data) {
                    alert(data);
                }
            });
        }

        function addCode(){
            var selectList = '<div><select for="contact_edit_from" name="jeffcodes[]" class="jeffcodes form-control input-sm">';
            @foreach($jeffcodes as $jeffcode)
                selectList += "<option value='{{ $jeffcode->id }}'"
                +">{{ $jeffcode->jeffcode }}</option>";
            @endforeach
                selectList += "</select>"+
                "<button type='button' class='btn btn-danger' onclick='$(this).parent().remove();'>Remove</button>"+
                "</div>";
            $('#codes_area').append(selectList);
        }

        function addSub(){
            var input = '<input type="text" name="company" id="company" class="form-control input-sm" tabindex="4" value="">'
            $('#sub_select').html(input);
            $('#add_sub_company').attr("disabled", true);
        }

        function conremove(){
            @if(auth()->user()->remove)
            var r=confirm("Do you want to remove this contact?");
            if (r==true)
                return true;
            else
                return false;
            @else
            var r=alert("You're not allowed to remove records")
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
                $('#ready').prop( "checked", false );
                $('#buyer').prop( "checked", false );
                $('#optedout').prop( "checked", false );
                $('#notes').val('');
                $('#contact_edit_from').attr('action', "{{ url('database/add')}}");
                $( "#contact_edit_from" ).submit();
                return false;
            }
            else
                return false;
            @else
            alert("You're not allowed to duplicate records");
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

        $('#main_company').on('change', function() {
            var options = '';
            $.ajax({
                type:'GET',
                url:"{{ url('company/getsub')}}/",
                data: { main_company: $('#main_company').val() },
                success:function(data) {
                    options += '<option value=""></option>';
                    data.forEach(function(element) {
                        options += '<option value="'+element.sub_company+'">'+element.sub_company+'</option>'
                    });
                    $('#company').empty().append(options);
                    getComData();
                }
            })

        });

        $('#company').on('change', function() {
            getComData();
        });

        $('#first_name').on('change', function() {
            setWorkEmail();
        });

        $('#last_name').on('change', function() {
            setWorkEmail();
        });

        function setWorkEmail(){
            if ($('#work_email').val() || $('#email_pattern').text().toLowerCase() === 'no pattern'){
                return;
            }
            if (!$('#first_name').val() || !$('#last_name').val() ){
                return;
            }
            var email_pattern = $('#email_pattern').text().toLowerCase();
            var firstname = $('#first_name').val().replaceAll(' ','');
            var lastname = $('#last_name').val().replaceAll(' ','')
            var work_email = '';
            while (email_pattern && email_pattern.charAt(0) != '@' && email_pattern.length != 0){
                if(email_pattern.indexOf('firstname') == 0){
                    work_email += firstname;
                    email_pattern = email_pattern.substr(9);
                    continue;
                }
                if(email_pattern.indexOf('firstinitial') == 0){
                    work_email += firstname.charAt(0);
                    email_pattern = email_pattern.substr(12);
                    continue;
                }
                if(email_pattern.indexOf('lastname') == 0){
                    work_email += lastname;
                    email_pattern = email_pattern.substr(8);
                    continue;
                }
                if(email_pattern.indexOf('lastinitial') == 0){
                    work_email += lastname.charAt(0);
                    email_pattern = email_pattern.substr(11);
                    continue;
                }
                if(email_pattern.indexOf('+') == 0){
                    email_pattern = email_pattern.substr(1);
                    continue;
                }
                work_email += email_pattern.charAt(0);
                email_pattern = email_pattern.substr(1);
            }
            work_email += email_pattern;
            $('#work_email').val(work_email.toLowerCase());
        }

        var current_position = 0;
        var last_position = null;

        function searchList(search_value){
            var search_list = [];
            $('#officeList').children().each(function() {
                if ($(this).find('[name="type"]').val().toLowerCase().includes(search_value))
                    search_list.push(this.querySelector('[name="type"]'));
                if ($(this).find('[name="city"]').val().toLowerCase().includes(search_value))
                    search_list.push(this.querySelector('[name="city"]'));
                if ($(this).find('[name="state"]').val().toLowerCase().includes(search_value))
                    search_list.push(this.querySelector('[name="state"]'));
                if ($(this).find('[name="country"]').val().toLowerCase().includes(search_value))
                    search_list.push(this.querySelector('[name="country"]'));
                if ($(this).find('[name="office_phone"]').val().toLowerCase().includes(search_value))
                    search_list.push(this.querySelector('[name="office_phone"]'));
            });
            return search_list;
        }

        function SearchUp(){
            var search_value = $('#loc_search').val();
            while(search_value.slice(-1) === ' ')
                search_value = search_value.slice(0, -1);
            if (!search_value){
                return;
            }
            var offices = searchList(search_value.toLowerCase());
            if (!offices.length){
                alert("no such value");
                return;
            }
            if(last_position)
                last_position.style.backgroundColor= "#eee";
            if (current_position < 0 || current_position > offices.length -1)
                current_position = offices.length-1;
            offices[current_position].scrollIntoView();
            offices[current_position].style.backgroundColor= "antiquewhite";
            last_position = offices[current_position];
            current_position--;
        }

        function SearchDown(){
            var search_value = $('#loc_search').val();
            while(search_value.slice(-1) === ' ')
                search_value = search_value.slice(0, -1);
            if (!search_value){
                return;
            }
            var offices = searchList(search_value.toLowerCase());
            if (!offices.length){
                alert("no such value");
                return;
            }
            if(last_position)
                last_position.style.backgroundColor= "#eee";
            if (current_position < 0 || current_position > offices.length -1)
                current_position = 0;
            offices[current_position].scrollIntoView();
            offices[current_position].style.backgroundColor= "antiquewhite";
            last_position = offices[current_position];
            current_position++;
        }

        function addOffice(){
            var htmlcode = $('#officeForm').html();
            $('#officeList').append(htmlcode);
        }

        function setOfficeData(officeform){
            var city = $(officeform).find('[name="city"]').val();
            $('#city').val(city);
            var state = $(officeform).find('[name="state"]').val();
            $('#states').val(state);
            var country = $(officeform).find('[name="country"]').val();
            $('#country').val(country);
            var office_phone = $(officeform).find('[name="office_phone"]').val();
            $('#office_phone').val(office_phone);
            $('#companyModal').modal('hide')
        }

        function getComData(){
            var options = '';
            $.ajax({
                type:'GET',
                url:"{{ url('company/getcomdata')}}/",
                data: { main_company: $('#main_company').val(), sub_company: $('#company').val() },
                success:function(data) {
                    if (typeof data[0] === 'undefined')
                        return;
                    $('#email_pattern').text('');
                    $('#email_pattern').text(data[0].email_pattern);
                    setWorkEmail();
                    $('#codes_area').children().remove();
                    data[0].jeffcodes.forEach(function(jeffcode) {
                        addCode();
                        $('#codes_area').find('.jeffcodes').last().val(jeffcode.id);
                    });
                    $('#officeList').children().remove();
                    current_position = 0;
                    data[0].offices.forEach(function(office) {
                        addOffice();
                        $('#officeList').find('[name="type"]').last().val(office.type);
                        $('#officeList').find('[name="city"]').last().val(office.city);
                        $('#officeList').find('[name="state"]').last().val(office.state);
                        $('#officeList').find('[name="country"]').last().val(office.country);
                        $('#officeList').find('[name="office_phone"]').last().val(office.office_phone);
                    });
                }
            });
        }

        $('#states').on('change', function() {
            var selected = $("option:selected", this);
            switch (selected.parent()[0].id ) {
                case 'us':
                    $('#country').val("United States");
                    break;
                case 'canada':
                    $('#country').val("Canada");
                    break;
                case 'australia':
                    $('#country').val("Australia");
                    break;
            }
            getPhonePattern();
        });

        $('#country').on('change', function() {
            getPhonePattern();
        });

        function getPhonePattern(){
            $('#phone_m_patterns').empty();
            $('#phone_l_patterns').empty();
            $.ajax({
                type:'GET',
                url:"{{ url('database/phone_pattern/')}}/"+$('#country').val(),
                success:function(data) {
                    for(var i = 0; data.land[i]; i++) {
                        if (data.land[i].length == $('#office_phone').val().length || data.land[i].length == $('#direct_phone').val().length)
                            $('#phone_l_patterns').append('<option value="'+data.land[i]+'" selected>'+data.land[i]+'</option>');
                        else
                            $('#phone_l_patterns').append('<option value="'+data.land[i]+'">'+data.land[i]+'</option>');
                    }
                    UpdatePhone("phone_l_patterns","#direct_phone");
                    for(var i = 0; data.mobile[i]; i++) {
                        if (data.mobile[i].length == $('#mobile_phone_a').val().length || data.mobile[i].length == $('#mobile_phone_b').val().length)
                            $('#phone_m_patterns').append('<option value="'+data.mobile[i]+'" selected>'+data.mobile[i]+'</option>');
                        else
                            $('#phone_m_patterns').append('<option value="'+data.mobile[i]+'">'+data.mobile[i]+'</option>');
                    }
                    UpdatePhone("phone_m_patterns","#mobile_phone_a");
                    UpdatePhone("phone_m_patterns","#mobile_phone_b");
                },
                error:function(data) {
                }
            })
        }

        $('#phone_l_patterns').on('change', function() {
            UpdatePhone("phone_l_patterns","#direct_phone");
        });

        $('.lphone').on('change', function() {
            UpdatePhone("phone_l_patterns",this)
        });

        $('#phone_m_patterns').on('change', function() {
            UpdatePhone("phone_m_patterns","#mobile_phone_a");
            UpdatePhone("phone_m_patterns","#mobile_phone_b");
        });

        $('.mphone').on('change', function() {
            UpdatePhone("phone_m_patterns",this)
        });

        function UpdatePhone(listid,field){
            var pattern = $("option:selected","#"+listid).val();
            var input = $(field).val().replaceAll(/\D/g,'');
            var xcount = (pattern.match(/X/g) || []).length;

            if (input.length<xcount)
                return;
            var replacement = input.slice(-1);
            for (let i = 2; i < xcount+2; i++) {
                pattern = pattern.replace(/X([^X]*)$/, replacement + '$1');
                replacement = input.slice(-i, -i+1);
            }
            $(field).val(pattern);
        }

        $('#li').on('change', function() {
            var url = $(this).val();
            var position = url.indexOf("www.linkedin.com/in/");//www.linkedin.com/in/ length = 20
            if(position == -1){
                alert("incorrect linkedin url");
                $(this).val("");
                return;
            }
            url = url.substr(position);
            position = url.indexOf("/",20);
            if(position != -1){
                url = url.substring(0,position);
            }
            $(this).val(url);
        });

        $('#cost').on('change', function() {
            if ($(this).val() == '' || $(this).val() < 1) {
                $(this).val(1);
                return;
            }
            if ($(this).val() > 5) {
                $(this).val(5);
            }
        });

        @if (isset($contact))
        $(document).ready(function() {
            if($('#main_company').val()){
                $.ajax({
                    type:'GET',
                    url:"{{ url('company/getcomdata')}}/",
                    data: { main_company: $('#main_company').val(), sub_company: $('#company').val() },
                    success:function(data) {
                        $('#officeList').children().remove();
                        data[0].offices.forEach(function(office) {
                            addOffice();
                            $('#officeList').find('[name="type"]').last().val(office.type);
                            $('#officeList').find('[name="city"]').last().val(office.city);
                            $('#officeList').find('[name="state"]').last().val(office.state);
                            $('#officeList').find('[name="country"]').last().val(office.country);
                            $('#officeList').find('[name="office_phone"]').last().val(office.office_phone);
                        });
                    }
                });
            }
            if($('#country').val()){
                getPhonePattern();
            }
        });
        @endif

    </script>
@endsection
