@extends ('layout')

@section ('content')

<h1>Customers Index</h1>
@foreach ($body['list'] as $customer)
  <div class="card">
    ID: {{ $customer['id'] }} <br>
    Company: {{$customer['company']}} <br>
    Name: {{ $customer['first_name'] . " " . $customer['last_name'] }} <br>
    Address:<br>
    {{ $customer['address_1'] }} <br>
    {{ $customer['city'] . ", " . $customer['state'] }} <br>
    {{ $customer['zip'] }} <br>
    Email: {{ $customer ['email'] }} <br>
    Phone: {{ $customer ['phone'] }} <br>

  </div>
@endforeach

@endsection