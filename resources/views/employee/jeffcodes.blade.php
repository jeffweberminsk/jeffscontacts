@extends('layouts.admin')

@section('content')
<div id="searchmain">
    <form role="form" action="{{ url('jeffcode/')}}" method="get">
        <input id="jeffcode_search"  type="text" class="form-control" placeholder="jeffcode " name="jeffcode_search"
        value="{{ app('request')->input('jeffcode_search') }}">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>   
</div>
@error('jeffcodes')
<span class="invalid-feedback" role="alert">
    <strong>{{ $message }}</strong>
</span>
@enderror
    <div id="searchtable" class="col-lg-10 col-md-10 col-sm-10">

       <div style="width:100%;">
            <div style="float:left;">{{ $jeffcodes->appends($input)->links('employee.custom') }}</div>
        </div>        

        <table class="table table-condensed" style="float:left;">
            <tr style="
                        font-size: 15px;
                            font-weight: bold;
                            color: rgba(45, 110, 163, 0.95);
                    ">
                <td style="white-space: nowrap;">jeffcode</td>
                <td style="width: 25%;">Actions</td>
            </tr>
            <tr>
            <form role="form" action="{{ url('jeffcode/add') }}" method="get">
                <td>
                    <input type="text" name="jeffcode" class="form-control input-sm">
                </td>
                <td style="width: 25%;">
                    <button type="submit" class="btn btn-sm btn-primary">New jeffcode</button>
                </td>
            </form> 
            </tr>
        @if (count($jeffcodes))
        @foreach($jeffcodes as $jeffcode)
            <tr>
            <form role="form" action="{{ url('jeffcode/'.$jeffcode->id) }}" method="get">
                <td>
                    <input type="text" name="jeffcode" class="form-control input-sm"
                        value="{{ $jeffcode->jeffcode }}">
                </td>
                <td style="width: 25%;">
                    <button onclick="return edit()" type="submit" class="btn btn-sm btn-warning">Save changes</button>
            </form> 
                    <a href="{{ url('jeffcode/remove/'.$jeffcode->id) }}"> 
                    <button onclick="return remove()" class="btn btn-sm btn-danger">Remove</button>
                    </a>
                </td>
              
            </tr>
        @endforeach
        @endif
        </table>
    </div>


<script type="text/javascript">

    function remove()
    {
        var r=confirm("Do you want to remove this jeffcode?")
        if (r==true)
            return true;
        else
            return false;
    }

    function edit()
    {
        var r=confirm("Do you want to edit this jeffcode?")
        if (r==true)
            return true;
        else
            return false;
    }

</script>
@endsection