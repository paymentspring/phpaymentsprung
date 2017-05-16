@extends ('layout')

@section ('content')
    <div align="center">
        <h1>PhPaymentSprung</h1>
        <a href="{{ url('customers') }}" class="btn btn-default">List Customers</a>
        <a href="{{ url('customers/new') }}" class="btn btn-default">Create a customer</a>
        <a href="{{ url('customers/search') }}" class="btn btn-default">Search for Customers</a>
        <a href="{{ url('charges/card') }}" class="btn btn-default">Charge a card</a>
        <a href="{{ url('charges/bank') }}" class="btn btn-default">Charge a bank account</a>
        <a href="{{ url('plans/new') }}" class="btn btn-default">Create a plan</a>
        <a href="{{ url('subscriptions/new') }}" class="btn btn-default">Create a subscription</a>
    </div>
@endsection
