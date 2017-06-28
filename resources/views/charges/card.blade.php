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
  <h1>Charge a card</h1>
  <form id="chargeForm" class="form-group">
    {{ csrf_field() }}
    <input type="text" id="card_holder_name" placeholder="Card Owner Name" class="form-control token-param">
    <input type="text" id="card_number" placeholder="Card Number" class="form-control token-param">
    <input type="text" id="csc" placeholder="CSC" class="form-control token-param">
    <input type="text" id="card_exp_month" placeholder="MM" class="form-control token-param">
    <input type="text" id="card_exp_year" placeholder="YYYY" class="form-control token-param">
    <input type="text" id="amount" placeholder="00.00" class="form-control">
    <input id="token_type" type="hidden" class="token-param" name"token_type" value="credit_card">
    <input type="submit" value="submit" class="btn btn-default">
  </form>
  <div id="response"></div>
@endsection
