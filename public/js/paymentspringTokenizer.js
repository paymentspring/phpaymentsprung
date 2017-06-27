// Build the prototype
window.paymentspring = (function () {

  function PaymentSpring() {
    this.script = null;
    this.callback = null;
    this.key = null;
  }

  // Generate the token:
  //
  // Params:
  // + public_key:  your paymentspring public API key (can be sandbox or live)
  // + paymentInfo: JSON object literal with params matching the documentation
  //                  https://paymentspring.com/developers/#create-a-token-with-jsonp
  // + callback:    this function will be called upon completion of the
  //                  tokenization process
  //
  // Returns:
  // JSON object literal formatted like so:
  // {
  //   "id": "24daa814b0",
  //   "class": "token",
  //   "card_type": "visa",
  //   "card_owner_name": "John Doe",
  //   "last_4": "1111",
  //   "card_exp_month": 1,
  //   "card_exp_year": 2020
  // }
  PaymentSpring.prototype.generateToken = function (public_key, paymentInfo, callback) {
    if (this.script) return;
    if(public_key.length != 63) {
      alert("This is not a public key!");
    } else {
      this.key = public_key;
    }

    this.callback = callback;
    this.script = document.createElement("script");
    this.script.type = "text/javascript";
    this.script.id = "tempscript";
    this.script.src = "https://api.paymentspring.com/api/v1/tokens/jsonp?"
      + this.buildQueryString(paymentInfo)
      + "&public_api_key=" + this.key
      + "&callback=paymentspring.onComplete";

    document.body.appendChild(this.script);
  };

  // Turn our incoming JSON params into a URI encoded query string
  //
  // We naively iterate over key/value pairs here, and do not do any validation
  // at this level.
  //
  // Params:
  // + cardInfo: Object literal, corresponding to JSONP token creation params
  //              https://paymentspring.com/developers/#create-a-token-with-jsonp
  //
  // Returns:
  // Formatted query string
  PaymentSpring.prototype.buildQueryString = function(cardInfo) {
    var str = [];

    // At the end of this step, we'll have something like this:
    // [ 'foo=bar', 'bar=hello%20friend' ]
    for(var key in cardInfo) {
      // We only want info from the actual submitted card info, instead of any
      // prototype it might belong to.
      if (cardInfo.hasOwnProperty(key)) {
        str.push(encodeURIComponent(key) + "=" + encodeURIComponent(cardInfo[key]));
      }
    }

    output = str.join("&");
    return output;
  };

  // On completion, run this function and call the callback
  PaymentSpring.prototype.onComplete = function(data) {
    document.body.removeChild(this.script);
    this.script = null;
    this.callback(data);
  };

  return new PaymentSpring();
}());
