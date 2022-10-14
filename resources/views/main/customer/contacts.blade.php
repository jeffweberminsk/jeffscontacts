@extends('layouts.customer')

@section('title')
Contacts
@endsection

@section('description')
@php
    $description = "Find work email, personal email, office phone, mobile phone and other contact information.";
    echo $description;
@endphp
@endsection

@section('view')
<div class="container">
<div class="row">
  <!-- BEGIN SEARCH RESULT -->
  <div class="col-md-12">
    <div class="grid search">
      <div class="grid-body">
        <div class="row">
          <!-- BEGIN RESULT -->

            <h2 style="width: 100%">Contacts</h2>

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
@endsection