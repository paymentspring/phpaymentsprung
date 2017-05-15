@extends ('layout')

@section ('content')
    <h1>PhPaymentSprung</h1>
    <a href="{{ url('customers') }}">Customers</a>
    <a href="{{ url('customers/new') }}">Create a customer</a>
    <a href="{{ url('charges/card') }}">Charge a card</a>
@endsection