@extends ('layout')

@section ('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/paymentspringTokenizer.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/charge.js') }}"></script>
<script>
  var paymentspring_public_key = '{{ env('PAYMENTSPRING_PUBLIC_KEY') }}';
</script>
@endsection

@section ('content')
  <h1>Charge a bank account</h1>
  <form id="chargeForm" action="bank" method="post" class="form-group">
    {{ csrf_field() }}
    <div class="form-inline">
      <input type="text" id="bank_account_holder_first_name" name="bank_account_holder_first_name" placeholder="First Name" class="form-control">
      <input type="text" id="bank_account_holder_last_name" name="bank_account_holder_last_name" placeholder="Last Name" class="form-control">
    </div>
    <input type="text" id="bank_account_number" name="bank_account_number" placeholder="Account Number" class="form-control">
    <input type="text" id="bank_routing_number" name="bank_routing_number" placeholder="Routing Number" class="form-control">
    <select id="bank_account_type" name="bank_account_type" class="form-control">
      <option value="checking">Checking</option>
      <option value="savings">Savings</option>
    </select>
    <input id="amount" type="text" name="amount" placeholder="00.00" class="form-control">
    <input id="token_type" type="hidden" name"token_type" value="bank_account">
    <input type="submit" value="submit" class="btn btn-default">
  </form>
  <div id="response"></div>
@endsection
