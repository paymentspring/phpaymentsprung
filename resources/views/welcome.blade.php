@extends ('layout')

@section ('content')
    <h1>PhPaymentSprung</h1>
    <a href="{{ url('customers') }}" class="btn btn-default">Customers</a>
    <a href="{{ url('customers/new') }}" class="btn btn-default">Create a customer</a>
    <a href="{{ url('charges/card') }}" class="btn btn-default">Charge a card</a>
@endsection