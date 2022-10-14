@extends('layouts.customer')

@section('title')
    Contacts lists
@endsection

@section('description')
@php
    $description = "Find work email, personal email, office phone, mobile phone and other contact information.";
    echo $description;
@endphp
@endsection

@section('view')
@if (session('status'))
    <div style="width: 100%; background-color: aquamarine;">
        {{ session('status') }}
    </div>
@endif
<div class="container">
<div class="row">
  <!-- BEGIN SEARCH RESULT -->
  <div class="col-md-12">
    <div class="grid search">
      <div class="grid-body">
        <div class="row">
          <!-- BEGIN RESULT -->

            <h2 style="width: 100%">Lists</h2>
            <div style="
            display: flex;
            flex-direction: column;
            ">
                <form action="{{ url('customer/newlist') }}" method="POST">
                    @csrf
                    <label for="lists">New list</label>
                    <input type="text" name="name" id="new_list">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input type="submit" value="add">
                </form>
                <br>        
                @isset($lists)
                <form  action="{{ url('customer/lists') }}" method="GET">
                  <label for="list">Selected List:</label>
                  <select name="list" id="lists">
                      @foreach($lists as $list)
                          <option value='{{ $list->id }}' @if($list->id == $seleted_list) selected @endif>{{ $list->name }}</option>        
                      @endforeach
                  </select>
                  <button type="submit">show</button>
                </form>
                <form  action="{{ url('customer/lists') }}" method="POST">
                  @csrf
                  <button type="submit">export</button>                    
                </form>
                <form  id="deleteForm" onsubmit="return confirmRemove();" action="{{ url('customer/deletelist') }}" method="POST">
                  @csrf
                  <input type="hidden" name="list" value="{{ $seleted_list }}">
                  <button type="submit" >delete</button>
                </form>
                @endisset
                
            </div>

            @isset($results)
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
                        <td class="image"><img src="{{ Storage::url($result->photo) }}" alt="{{ ($result->first_name ?? '' ).' '.($result->last_name ?? '') }}"></td>
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
                            <a href="{{ url('contact/'.$result->slug) }}">  <button class="btn btn-sm search-button">Go to Contact</button></a>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <div style="text-align: center; margin-bottom: 28.65%;">
                        <h3>No contacs</h3>
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

          <!-- END RESULT -->

        </div>
      </div>
    </div>
  </div>
  <!-- END SEARCH RESULT -->
</div>
</div>

<script>

function confirmRemove(){
  var select = document.getElementById("lists");
  var listname = select.options[select.selectedIndex].text;
  if(!confirm('Delete list '+listname)){
    return false;
  }
  return true;
}

</script>
@endsection