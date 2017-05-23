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
      url: '/charges/card',
      data: { _token: _token, params: params},
      type: 'POST',
      success: function(data) {
        $( '#response' ).append('Success!');
      },
      error: function(data) {
        $ ( '#response' ).append('Error! ' + params['token']['errors'][0]['code'] + ' ' + params['token']['errors'][0]['message']);
      }
    });
  }

  $( '#card_form' ).submit(function(event)
  {
    // Form submit events don't play nice with jsonp callbacks, so we prevent default behavior
    event.preventDefault();

    // Clear any previous responses
    $( '#response' ).empty();

    // Grab data from form
    var public_key = 'test_98c218fbbcc231cb863d76983582f3cbc456c325d2687aa30e2006cf3a';
    var card_holder = $( '#card_holder' ).val();
    var card_number = $( '#card_number' ).val();
    var csc = $( '#csc' ).val();
    var exp_month = $( '#exp_month' ).val();
    var exp_year = $( '#exp_year' ).val();

    // Generate token
    paymentspring.generateToken(public_key, card_number, csc, card_holder, exp_month, exp_year, callback);
  });
});