@extends ('layout')

@section ('content')
  <h1>Charge a card</h1>
  <form action="card" method="post">
    {{ csrf_field() }}
    <input type="text" name="card_owner_name" placeholder="Card Owner Name">
    <input type="text" name="card_number" placeholder="Card Number">
    <input type="text" name="expiration_date" placeholder="MM/YYYY">
    <input type="text" name="csc" placeholder="CSC">
    <input type="text" name="amount" placeholder="00.00">
    <input type="submit" value="submit">
  </form>
@endsection