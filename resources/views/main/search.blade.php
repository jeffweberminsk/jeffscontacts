@extends('layouts.app')

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
            
            <!-- BEGIN FILTER BY DATE -->
            <h4>Job Title:</h4>            
            <input form="form" id="job" type="text" name="job" class="form-control" placeholder="Job Title" value="{{ app('request')->input('job') ?? ''}}">
            <h4>Company:</h4>            
            <input form="form" id="company" type="text" name="company" class="form-control" placeholder="Company" value="{{ app('request')->input('company') ?? ''}}">
            <h4>City:</h4>            
            <input form="form" id="city" type="text" name="city" class="form-control" placeholder="City" value="{{ app('request')->input('city') ?? ''}}">
            <h4>Country:</h4>            
            <input form="form" id="country" type="text" name="country" class="form-control" placeholder="Country" value="{{ app('request')->input('country') ?? ''}}">
            <h4>Jeffcode:</h4>            
            <input form="form" id="jeffcode" type="text" name="jeffcode" class="form-control" placeholder="Jeffcode" value="{{ app('request')->input('jeffcode') ?? ''}}">
            <!-- END FILTER BY DATE -->
            
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
                        <td class="image"><img src="{{ $result->photo ?? ''}}" alt="{{ ($result->firsname ?? '' ).' '.($result->lastname ?? '') }}"></td>
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
                            <a href="{{ url('contact/'.$result->id) }}">  <button class="btn btn-sm search-button">Go to Contact</button></a>
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
              <div style="float:left;">{{ $results->links('employee.custom') ?? ''}}</div>
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
@endsection