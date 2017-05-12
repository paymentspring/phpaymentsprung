@extends ('layout')

@section ('content')

  <h1>Create a customer</h1>

  <form action="/customers" method="post">
    {{ csrf_field() }}
    <input type="text" name="company" placeholder="Company Name">
    <input type="text" name="first_name" placeholder="First Name">
    <input type="text" name="last_name" placeholder="Last Name">
    <input type="text" name="address_1" placeholder="Address 1">
    <input type="text" name="address_2" placeholder="Address 2">
    <input type="text" name="city" placeholder="City">
    <input type="text" name=state placeholder="State">
    <input type="text" name=zip placeholder="Zip">
    <input type="text" name=phone placeholder="Phone Number">
    <input type="text" name=fax placeholder="Fax Number">
    <input type="text" name=website placeholder="Website">
    <input type="text" name=card_number placeholder="Card Number">
    <input type="text" name=card_exp placeholder="MM/YY">
    <input type="submit" value="submit">
  </form>

@endsection