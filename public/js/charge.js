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
      url: '/charges/',
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
    tokenParams = $(".token-param");
    var paymentInfo = {}
    for(var i = 0; i < tokenParams.length; i++) {
      paymentInfo[tokenParams[i].id] = tokenParams[i].value;
    }

    // Generate token
    paymentspring.generateToken(publicKey, paymentInfo, callback);
  });
});
