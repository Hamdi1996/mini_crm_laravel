@extends('layouts.app')

@section('content')
<input type="hidden" name="" value="{{$increment=1}}" id="">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">All Customers</div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Customers Name</th>
                <th scope="col">Customers Email </th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              @if(count($customers))
              @foreach($customers as $customer)
              <tr>
                <th scope="row">{{$increment}}</th>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>
                  <button type="button" data-target="#customer_{{ $customer->id }}" class="btn btn-sm btn-primary mt-1" data-toggle="modal">
                    Actions
                  </button>
                  @include('actionCustomersModal', ['id' => $customer->id, 'name' => $customer->name])
                </td>
              </tr>
              <input type="hidden" name="" value="{{$increment++}}" id="">
              @endforeach
              @else
              <p>There's no customers in our database, <a href="{{ route('customers.create') }}">Create new</a></p>
              @endif

            </tbody>
          </table>

        
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
