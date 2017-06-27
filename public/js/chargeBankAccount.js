// Charge a bank account
$(document).ready(function() {
  console.log(paymentspring_public_key);

  function callback(response) {
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

  $( '#chargeForm' ).submit(function(event) {
    // Form submit events don't play nice with jsonp callbacks, so we prevent default behavior
    event.preventDefault();

    // Clear any previous responses
    $( '#response' ).empty();

    // Grab data from form
    var publicKey = paymentspring_public_key;
    var bankInfo= {
      "bank_account_holder_first_name": $( '#bank_account_holder_first_name' ).val(),
      "bank_account_holder_last_name": $( '#bank_account_holder_last_name' ).val(),
      "bank_account_number": $( '#bank_account_number' ).val(),
      "bank_routing_number": $( '#bank_routing_number' ).val(),
      "bank_account_type": $( '#bank_account_type' ).val(),
      "token_type": $('#token_type').val()
    };

    console.log(bankInfo);

    // Generate token
    paymentspring.generateToken(publicKey, bankInfo, callback);
  });
});
