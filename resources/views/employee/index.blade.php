@extends('layouts.app')

@section('content')
<input type="hidden" name="" value="{{$increment=1}}" id="">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">All employees</div>

        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Employee Name</th>
                <th scope="col">Employee Email </th>
              </tr>
            </thead>
            <tbody>
              @if(count($employees))
              @foreach($employees as $employee)
              <tr>
                <th scope="row">{{$increment}}</th>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
              </tr>
              <input type="hidden" name="" value="{{$increment++}}" id="">
              @endforeach
              @else
              <p>There's no employees in our database, <a href="{{ route('employees.create') }}">Create new</a></p>
              @endif

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
