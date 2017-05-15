@extends ('layout')

@section ('content')

  <h1>Create a customer</h1>

  <form action="/customers" method="post" class="form-group">
    {{ csrf_field() }}
    <input type="text" name="company" placeholder="Company Name" class="form-control">
    <input type="text" name="first_name" placeholder="First Name" class="form-control">
    <input type="text" name="last_name" placeholder="Last Name" class="form-control">
    <input type="text" name="address_1" placeholder="Address 1" class="form-control">
    <input type="text" name="address_2" placeholder="Address 2" class="form-control">
    <input type="text" name="city" placeholder="City" class="form-control">
    <input type="text" name=state placeholder="State" class="form-control">
    <input type="text" name=zip placeholder="Zip" class="form-control">
    <input type="text" name=phone placeholder="Phone Number" class="form-control">
    <input type="text" name=fax placeholder="Fax Number" class="form-control">
    <input type="text" name=website placeholder="Website" class="form-control">
    <input type="text" name=card_number placeholder="Card Number" class="form-control">
    <input type="text" name=card_exp placeholder="MM/YY" class="form-control">
    <input type="submit" value="submit" class="btn btn-default">
  </form>

@endsection