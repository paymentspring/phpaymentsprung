@extends ('layout')

@section ('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('js/paymentspringTokenizer.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/customerCreate.js') }}"></script>
<script>
  var paymentspring_public_key = '{{ env('PAYMENTSPRING_PUBLIC_KEY') }}';
</script>
@endsection

@section ('content')

  <h1>Create a customer</h1>

  <form id="customerForm" action="/customers" method="post" class="form-group">
    {{ csrf_field() }}
    <input type="text" id="company" placeholder="Company Name" class="form-control token-param">
    <input type="text" id="card_owner_name" placeholder="Card Owner Name" class="form-control token-param">
    <input type="text" id="address_1" placeholder="Address 1" class="form-control token-param">
    <input type="text" id="address_2" placeholder="Address 2" class="form-control token-param">
    <input type="text" id="city" placeholder="City" class="form-control token-param">
    <input type="text" id="state" placeholder="State" class="form-control token-param">
    <input type="text" id="zip" placeholder="Zip" class="form-control token-param">
    <input type="text" id="phone" placeholder="Phone Number" class="form-control token-param">
    <input type="text" id="fax" placeholder="Fax Number" class="form-control token-param">
    <input type="text" id="website" placeholder="Website" class="form-control token-param">
    <input type="text" id="card_number" placeholder="Card Number" class="form-control token-param">
    <input type="text" id="card_exp_month" placeholder="MM" class="form-control token-param">
    <input type="text" id="card_exp_year" placeholder="YYYY" class="form-control token-param">
    <input type="text" id="csc" placeholder="CSC/CVV" class="form-control token-param">
    <input id="token_type" type="hidden" class="token-param" name"token_type" value="credit_card">
    <input type="submit" value="submit" class="btn btn-default">
  </form>
  <div id="response"></div>

@endsection
