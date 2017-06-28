$(document).ready(function() {

  function callback(response) {
    // Grab the CSRF token
    var _token = $('input[name="_token"]').val();

    // set customer creation token
    var params = {
      token: response
    };

    $.ajax({
      url: '/customers',
      data: { _token: _token, params: params},
      type: 'POST',
      success: function(data) {
        $( '#response' ).append('Success! Customer Created!');
      },
      error: function(data) {
        $ ( '#response' ).append('Error! ' + data.responseJSON.message );
      }
    });
  }

  $( '#customerForm' ).submit(function(event) {
    // Form submit events don't play nice with jsonp callbacks, so we prevent default behavior
    event.preventDefault();

    // Clear any previous responses
    $( '#response' ).empty();

    // Grab data from form
    var publicKey = paymentspring_public_key;
    tokenParams = $(".token-param");
    var customerInfo = {}
    for(var i = 0; i < tokenParams.length; i++) {
      customerInfo[tokenParams[i].id] = tokenParams[i].value;
    }

    // Generate token
    paymentspring.generateToken(publicKey, customerInfo, callback);
  });
});
