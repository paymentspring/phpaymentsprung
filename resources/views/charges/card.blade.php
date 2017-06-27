@extends ('layout')

@section ('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/paymentspringTokenizer.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/chargeCard.js') }}"></script>
<script>
  var paymentspring_public_key = '{{ env('PAYMENTSPRING_PUBLIC_KEY') }}';
</script>
@endsection

@section ('content')
  <h1>Charge a card</h1>
  <form id="card_form" class="form-group">
    {{ csrf_field() }}
    <input type="text" id="card_holder" placeholder="Card Owner Name" class="form-control">
    <input type="text" id="card_number" placeholder="Card Number" class="form-control">
    <input type="text" id="csc" placeholder="CSC" class="form-control">
    <input type="text" id="exp_month" placeholder="MM" class="form-control">
    <input type="text" id="exp_year" placeholder="YYYY" class="form-control">
    <input type="text" id="amount" placeholder="00.00" class="form-control">
    <input id="token_type" type="hidden" name"token_type" value="credit_card">
    <input type="submit" value="submit" class="btn btn-default">
  </form>
  <div id="response"></div>
@endsection
