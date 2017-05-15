@extends ('layout')

@section ('content')
  <h1>Charge a card</h1>
  <form action="card" method="post" class="form-group">
    {{ csrf_field() }}
    <input type="text" name="card_owner_name" placeholder="Card Owner Name" class="form-control">
    <input type="text" name="card_number" placeholder="Card Number" class="form-control">
    <input type="text" name="expiration_date" placeholder="MM/YYYY" class="form-control">
    <input type="text" name="csc" placeholder="CSC" class="form-control">
    <input type="text" name="amount" placeholder="00.00" class="form-control">
    <input type="submit" value="submit" class="btn btn-default">
  </form>
@endsection