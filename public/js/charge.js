$(document).ready(function() {

  function callback(response)
  {
    // Grab the CSRF token
    var _token = $('input[name="_token"]').val();

    // Set amount and transaction token
    var params = {
      amount: $( '#amount' ).val(),
      token: response
    };

    $.ajax({
      url: '/charges/new',
      data: { _token: _token, params: params},
      type: 'POST',
      success: function(data) {
        var dataJSON = JSON.parse(data);
        $( '#response' ).append('Success! Transaction status: ' + dataJSON.status);
      },
      error: function(data) {
        $ ( '#response' ).append('Error! ' + data.responseJSON.code + ' ' + data.responseJSON.message);
      }
    });
  }

  $( '#chargeForm' ).submit(function(event)
  {
    // Form submit events don't play nice with jsonp callbacks, so we prevent default behavior
    event.preventDefault();

    // Clear any previous responses
    $( '#response' ).empty();

    // Grab data from form
    var publicKey = paymentspring_public_key;
    var paymentInfo = {
      "card_owner_name": $( '#card_holder' ).val(),
      "card_number": $( '#card_number' ).val(),
      "csc": $( '#csc' ).val(),
      "card_exp_month": $( '#exp_month' ).val(),
      "card_exp_year": $( '#exp_year' ).val(),
      "bank_account_holder_first_name": $( '#bank_account_holder_first_name' ).val(),
      "bank_account_holder_last_name": $( '#bank_account_holder_last_name' ).val(),
      "bank_account_number": $( '#bank_account_number' ).val(),
      "bank_routing_number": $( '#bank_routing_number' ).val(),
      "bank_account_type": $( '#bank_account_type' ).val(),
      "token_type": $('#token_type').val()
    };

    // Generate token
    paymentspring.generateToken(publicKey, cardInfo, callback);
  });
});
