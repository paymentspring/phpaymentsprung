@extends ('layout')

@section ('content')
    <div align="center">
        <h1>PhPaymentSprung</h1>
        <a href="{{ url('customers') }}" class="btn btn-default">Customers</a>
        <a href="{{ url('customers/new') }}" class="btn btn-default">Create a customer</a>
        <a href="{{ url('charges/card') }}" class="btn btn-default">Charge a card</a>
    </div>
@endsection