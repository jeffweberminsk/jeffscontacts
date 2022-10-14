@extends('layouts.admin')

@section('content')
<div id="searchmain">
    <form role="form" action="{{ url('company/')}}" method="get">
        <input id="company_name"  type="text" class="form-control" placeholder="company name" name="company_name"
        value="{{ app('request')->input('company') }}">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>   
</div>
    <div style="margin-left: 15px;">{{ $companies->appends($input)->links('employee.custom') }}</div>

    <div id="searchtable" class="col-lg-10 col-md-10 col-sm-10">

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#companyModal" data-company="0">New company</button>
        
        <table class="table table-condensed" style="float:left;">
            <tr style="font-size: 15px; font-weight: bold; color: rgba(45, 110, 163, 0.95); ">
                <td style="white-space: nowrap;">Main company</td>
                <td style="white-space: nowrap;">Sub company</td>
                <td >Actions</td>
            </tr>
        @if (count($companies))
        @foreach($companies as $company)
            <tr>
                <td>
                    <input id="{{ 'main_company_'.$company->id }}" type="text" class="form-control input-sm"
                        value="{{ $company->main_company }}" readonly>
                </td>
                <td>
                    <input id="{{ 'sub_company_'.$company->id }}" type="text" class="form-control input-sm"
                            value="{{ $company->sub_company }}" readonly>
                </td>
                <td style="width: 30%;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#companyModal" data-company="{{ $company->id }}">Edit company</button>
                    <a href="{{ url('company/remove/'.$company->id) }}"> 
                    <button class="btn btn-sm btn-danger" onclick="return remove()">Remove</button>
                    </a>
                </td>              
            </tr>
        @endforeach
        @endif
        </table>
    </div>

    <div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="companyModalLabel" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="companyModalLabel">Edit company</h5>
            </div>
            <form id="edit_form" class="edit_form" role="form" action=""  autocomplete="nope" method="post">
                @csrf
            <div class="modal-body">
                <table class="table" >
                <tr>
                    <td style="width: 25%;" >Main company:</td>
                    <td>
                        <input type="text" id="main_company" name="main_company" class="form-control input-sm" tabindex="1" autocomplete="nope">
                        <strong id="main_error" style="display: none">The main company field is required.</strong>
                    </td>
                </tr>
                <tr>
                    <td>Sub company: </td>
                    <td>
                        <input type="text" id="sub_company" name="sub_company" class="form-control input-sm" tabindex="2" autocomplete="nope">
                        <strong id="sub_error" style="display: none">The sub company has already been taken.</strong>                
                    </td>
                </tr>
                <tr>
                    <td>Email pattern: </td>
                    <td>
                        <input list="patterns_list" type="email" id="email_pattern" name="email_pattern" class="form-control input-sm" tabindex="3" autocomplete="nope">           
                        <datalist id="patterns_list">
                            <option value="firstname+lastname@">
                            <option value="firstinitial+lastname@">
                            <option value="firstname+lastinitial@">
                            <option value="firstinitial+lastinitial@">
                            <option value="firstname.lastname@">
                            <option value="firstinitial.lastname@">
                            <option value="firstname.lastinitial@">
                            <option value="firstinitial.lastinitial@">
                        </datalist>
                    </td>
                </tr>
                <tr>
                    <td>Jeffcodes: </td>
                    <td>
                        <span id="codes_area" style="float:left;width:69%;overflow: auto;height: 100px;"> 
                        </span>
                        <div id="editJeffCode" onclick="addCode();" class="btn btn-sm verify-button" tabindex="4">Add</div>
                    </td>
                </tr>
                <tr>
                    <td>Offices: </td>
                    <td>
                    <div id="addOffice" style="float:left;" onclick="addOffice();" class="btn btn-sm verify-button" tabindex="5">New office</div>
                    </td>
                </tr>
                </table>
                <div id="officeList" style="height: 280px; overflow:auto;">                 

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" tabindex="6">Save changes</button>
            </div>
            </form> 
            </div>
        </div>
    </div>

    <div id="officeForm" hidden>
        <div class="form-group" style="border-top: 1px solid grey;">
            <p style="margin-bottom: 0px; margin-top: 5px;" >Office type:</p>
            <input type="text" name="type" class="form-control input-sm" autocomplete="nope">

            <p style="margin-bottom: 0px; margin-top: 5px;" >Address:</p>
            <input type="text" name="address" class="form-control input-sm" autocomplete="nope">

            <p style="margin-bottom: 0px; margin-top: 5px;" >City:</p>
            <input type="text" name="city" class="form-control input-sm" autocomplete="nope">

            <p style="margin-bottom: 0px; margin-top: 5px;" >State:</p>
            <select name="state"  onchange="changeState($(this));" class="form-control input-sm">
                <option></option>
                <optgroup id="us" label="US States">
                    <option value="Alabama">Alabama</option>
                    <option value="Alaska">Alaska</option>
                    <option value="Arizona">Arizona</option>
                    <option value="California">California</option>
                    <option value="Colorado">Colorado</option>
                    <option value="Connecticut">Connecticut</option>
                    <option value="Delaware">Delaware</option>
                    <option value="Florida">Florida</option>
                    <option value="Georgia">Georgia</option>
                    <option value="Hawaii">Hawaii</option>
                    <option value="Idaho">Idaho</option>
                    <option value="Illinois">Illinois</option>
                    <option value="Indiana">Indiana</option>
                    <option value="Iowa">Iowa</option>
                    <option value="Kansas">Kansas</option>
                    <option value="Kentucky">Kentucky</option>
                    <option value="Louisiana">Louisiana</option>
                    <option value="Maine">Maine</option>
                    <option value="Maryland">Maryland</option>
                    <option value="Massachusetts">Massachusetts</option>
                    <option value="Michigan">Michigan</option>
                    <option value="Minnesota">Minnesota</option>
                    <option value="Mississippi">Mississippi</option>
                    <option value="Missouri">Missouri</option>
                    <option value="Montana">Montana</option>
                    <option value="Nebraska">Nebraska</option>
                    <option value="Nevada">Nevada</option>
                    <option value="New Hampshire">New Hampshire</option>
                    <option value="New Jersey">New Jersey</option>
                    <option value="New Mexico">New Mexico</option>
                    <option value="New York">New York</option>
                    <option value="North Carolina">North Carolina</option>
                    <option value="North Dakota">North Dakota</option>
                    <option value="Ohio">Ohio</option>
                    <option value="Oklahoma">Oklahoma</option>
                    <option value="Oregon">Oregon</option>
                    <option value="Pennsylvania">Pennsylvania</option>
                    <option value="Rhode Island">Rhode Island</option>
                    <option value="South Carolina">South Carolina</option>
                    <option value="South Dakota">South Dakota</option>
                    <option value="Tennessee">Tennessee</option>
                    <option value="Texas">Texas</option>
                    <option value="Utah">Utah</option>
                    <option value="Vermont">Vermont</option>
                    <option value="Virginia">Virginia</option>
                    <option value="Washington">Washington</option>
                    <option value="West Virginia">West Virginia</option>
                    <option value="Wisconsin">Wisconsin</option>
                    <option value="Wyoming">Wyoming</option>
                </optgroup>             
                <optgroup id="canada" label="Canadian States">
                    <option value="Alberta">Alberta</option>
                    <option value="British Columbia">British Columbia</option>
                    <option value="Manitoba">Manitoba</option>
                    <option value="New Brunswick">New Brunswick</option>
                    <option value="Newfoundland">Newfoundland</option>
                    <option value="Nova Scotia">Nova Scotia</option>
                    <option value="Ontario">Ontario</option>
                    <option value="Prince Edward Island">Prince Edward Island</option>
                    <option value="Quebec">Quebec</option>
                    <option value="Saskatchewan">Saskatchewan</option>
                </optgroup>
                <optgroup id="australia" label="Australiaan States">
                    <option value="New South Wales">New South Wales</option>
                    <option value="Queensland">Queensland</option>
                    <option value="South Australia">South Australia</option>
                    <option value="Tasmania">Tasmania</option>
                    <option value="Victoria">Victoria</option>
                    <option value="Western Australia">Western Australia</option>
                </optgroup>
            </select>    

            <p style="margin-bottom: 0px; margin-top: 5px;" >Zip code:</p>
            <input type="text" name="zipcode" class="form-control input-sm" autocomplete="nope">

            <p style="margin-bottom: 0px; margin-top: 5px;" >Country:</p>
            <input list="countries" type="text" onchange="changeCountry($(this));" name="country" class="form-control input-sm" required autocomplete="nope">  
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

            <p style="margin-bottom: 0px; margin-top: 5px;" >Land phone pattern: </p>
            <select class="form-control input-sm phone_l_patterns" onchange="changePhone($(this));"></select>       
         
            <p style="margin-bottom: 0px; margin-top: 5px;" >Company Phone:</p>
            <input type="text" name="office_phone" class="form-control input-sm" onchange="changePhone($(this));" autocomplete="nope">
            
            <p style="margin-bottom: 0px; margin-top: 5px;" >Company FAX:</p>
            <input type="text" name="fax_phone" class="form-control input-sm" onchange="changePhone($(this));" autocomplete="nope">

            <button type='button' class='btn btn-danger' onclick="removeOffice($(this))" style="margin-top: 9px;">Remove office</button>
        </div>
    </div>

<script type="text/javascript">


    $(".edit_form").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var url = form.attr('action');
        $('#main_error').hide();
        $('#sub_error').hide();
        getOffices();
        if(url.includes('add'))
            addCompany(form);
        else
            editCompany(form);

    });

    function getOffices(){
        let offices = []; 
        $( "#officeList .form-group" ).each(function() {
            var office = new Object();
            office.type = $(this).find('[name="type"]').val();
            office.address = $(this).find('[name="address"]').val();
            office.city = $(this).find('[name="city"]').val();
            office.state = $(this).find('[name="state"]').val();
            office.zipcode = $(this).find('[name="zipcode"]').val();
            office.country = $(this).find('[name="country"]').val();
            office.office_phone = $(this).find('[name="office_phone"]').val();
            office.fax_phone = $(this).find('[name="fax_phone"]').val();
            offices.push(office);
        });
        return offices;
    }

    function addCompany(form){
        var r=confirm("Do you want to add this company?")
        if (!r)
            return 0;
        var url = form.attr('action');
        var id = form.attr('id').substr(5);
        $.ajax({
            type: "POST",
            url: url,
            data: { 
                _token: "{{ csrf_token() }}",
                main_company: $('#main_company').val(), 
                sub_company: $('#sub_company').val(), 
                email_pattern: $('#email_pattern').val(), 
                jeffcodes: $('[name="jeffcodes[]"]').map(function(){return $(this).val();}).get(),
                offices: getOffices(),
                },
            success:function(data) {
                location.reload();
            },
            error: function(xhr, status, error)
            {
                if(xhr.responseJSON.errors.main_company)
                    $('#main_error').show();
                if(xhr.responseJSON.errors.sub_company)
                    $('#sub_error').show();
            }
        });
    }

    function editCompany(form){
        var r=confirm("Do you want to edit this company?")
        if (!r)
            return 0;
        var url = form.attr('action');
        var id = form.attr('id').substr(5);
        $.ajax({
            type: "POST",
            url: url,
            data: { 
                _token: "{{ csrf_token() }}",
                main_company: $('#main_company').val(), 
                sub_company: $('#sub_company').val(), 
                email_pattern: $('#email_pattern').val(), 
                jeffcodes: $('[name="jeffcodes[]"]').map(function(){return $(this).val();}).get(),
                offices: getOffices(),
            },
            success:function(data) {
                $('#companyModal').find('.modal-title').text('Edit Company Success '+new Date().toLocaleTimeString());
                alert('Success');
                var main = $('#main_company').val();
                $('#main_company_'+data).val(main);
                var sub = $('#sub_company').val();
                $('#sub_company_'+data).val(sub);
            },
            error: function(xhr, status, error)
            {
                alert('Failed '+xhr.responseJSON.message);
                if(xhr.responseJSON.errors.main_company)
                    $('#main_error').show();
                if(xhr.responseJSON.errors.sub_company)
                    $('#sub_error').show();
            }
        });
    }

    function remove(){
        var r=confirm("Do you want to remove this company?")
        if (r==true)
            return true;
        else
            return false;
    }

    function addCode(){
        var selectList = '<div style="display: flex;justify-content: space-between; margin-bottom: 15px;">';
        selectList += '<select for="contact_edit_from" name="jeffcodes[]" class="jeffcodes form-control input-sm" style="margin: auto 7px auto 0">';
        @foreach($jeffcodes as $jeffcode)
            selectList += "<option value='{{ $jeffcode->id }}'"
            +">{{ $jeffcode->jeffcode }}</option>";         
        @endforeach
        selectList += "</select>"+
        "<button type='button' class='btn btn-danger' onclick='$(this).parent().remove();'>Remove code</button>"+
        "</div>";
        $('#codes_area').append(selectList);
    }

    function addOffice(){
        var htmlcode = $('#officeForm').html();
        $('#officeList').append(htmlcode);
    }

    function removeOffice(elem){
        var r=confirm("Do you want to remove this office?")
        if (r==true)
            elem.parent().remove();
    }

    $('#companyModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var company_id = button.data('company')
        var modal = $(this)
        $('#main_error').hide();
        $('#sub_error').hide();
        if (company_id == 0 ){
            modal.find('.modal-title').text('Add Company')
            modal.find('#edit_form').attr('action', "{{ url('company/add')}}");
            modal.find('input').val('');
            $('#codes_area').children().remove();
            $('#officeList').children().remove();
        } else {
            modal.find('.modal-title').text('Edit Company')
            modal.find('#edit_form').attr('action', "{{ url('company/') }}/"+company_id);
            getComData(company_id);
        }
    });

    function getComData(id){
        var options = '';
        $.ajax({
            type:'GET',
            url:"{{ url('company/getcomdata')}}/",
            data: { main_company: $('#main_company_'+id).val(), sub_company: $('#sub_company_'+id).val() },
            success:function(data) {
                $('#main_company').val(data[0].main_company);
                $('#sub_company').val(data[0].sub_company);
                $('#email_pattern').val(data[0].email_pattern);
                $('#codes_area').children().remove();
                data[0].jeffcodes.forEach(function(jeffcode) {
                    addCode();
                    $('#codes_area').find('.jeffcodes').last().val(jeffcode.id);
                });
                $('#officeList').children().remove();
                data[0].offices.forEach(function(office) {
                    addOffice();
                    $('#officeList').find('[name="type"]').last().val(office.type);
                    $('#officeList').find('[name="address"]').last().val(office.address);
                    $('#officeList').find('[name="city"]').last().val(office.city);
                    $('#officeList').find('[name="state"]').last().val(office.state);
                    $('#officeList').find('[name="zipcode"]').last().val(office.zipcode);
                    $('#officeList').find('[name="country"]').last().val(office.country);
                    $('#officeList').find('[name="office_phone"]').last().val(office.office_phone);
                    $('#officeList').find('[name="fax_phone"]').last().val(office.fax_phone);
                    changeCountry($('#officeList').find('[name="country"]').last());
                });
            }
        });
    }

    function getPhonePattern(form){
        var country = $(form).find('[name="country"]').val();
        $(form).find('.phone_l_patterns').empty();
        $.ajax({
            type:'GET',
            url:"{{ url('database/phone_pattern/')}}/"+country,
            data: { main_company: $('#main_company').val() },
            success:function(data) {
                for(var i = 0; data.land[i]; i++) {
                    if (data.land[i].length == $(form).find('[name="office_phone"]').val().length) 
                        $(form).find('.phone_l_patterns').append('<option value="'+data.land[i]+'" selected>'+data.land[i]+'</option>');
                    else
                        $(form).find('.phone_l_patterns').append('<option value="'+data.land[i]+'">'+data.land[i]+'</option>');
                } 
                changePhone($(form).find('.phone_l_patterns')); 
            }
        })
    }

    function changeState(caller){
        var selected = $("option:selected", caller);
        form = caller.parent()[0];
        switch (selected.parent()[0].id ) {
            case 'us':
                $(form).find('[name="country"]').val("United States");
                break;
            case 'canada':
                $(form).find('[name="country"]').val("Canada");
                break;
            case 'australia':
                $(form).find('[name="country"]').val("Australia");
                break;
        }
        getPhonePattern(form);
    }

    function changeCountry(caller) {
        getPhonePattern(caller.parent()[0]);
    }

    function UpdatePhone(pattern,phone_input){
        var input = phone_input.val().replaceAll(/\D/g,'');
        var xcount = (pattern.match(/X/g) || []).length;
        if (input.length<xcount)
            return;
        var replacement = input.slice(-1);
        for (let i = 2; i < xcount+2; i++) {
            pattern = pattern.replace(/X([^X]*)$/, replacement + '$1');
            replacement = input.slice(-i, -i+1);
        }
        phone_input.val(pattern);
    }

    function changePhone(caller) {
        var form = caller.parent()[0];
        var pattern = $(form).find(".phone_l_patterns").find("option:selected").val();
        var phone_input = $(form).find('[name="office_phone"]');
        UpdatePhone(pattern,phone_input);
        var phone_input = $(form).find('[name="fax_phone"]');
        UpdatePhone(pattern,phone_input);
    }

</script>
@endsection