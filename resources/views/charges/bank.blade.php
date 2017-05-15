@extends ('layout')

@section ('content')
  <h1>Charge a bank account</h1>
  <form action="bank" method="post" class="form-group">
    {{ csrf_field() }}
    <div class="form-inline">
      <input type="text" name="bank_account_holder_first_name" placeholder="First Name" class="form-control">
      <input type="text" name="bank_account_holder_last_name" placeholder="Last Name" class="form-control">
    </div>
    <input type="text" name="bank_account_number" placeholder="Account Number" class="form-control">
    <input type="text" name="bank_routing_number" placeholder="Routing Number" class="form-control">
    <select name="bank_account_type" class="form-control">
      <option value="checking">Checking</option>
      <option value="savings">Savings</option>
    </select>
    <input type="text" name="amount" placeholder="00.00" class="form-control">
    <input type="submit" value="submit" class="btn btn-default">
  </form>
@endsection
