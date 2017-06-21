# PHPaymentSprung

PHPaymentSprung is a sample app demonstrating PaymentSpring's API interacting
with the Laravel PHP framework.

## Getting Started

PHPaymentSprung was created using Laravel 5.4. Running it with older versions
may lead to unexpected results! After getting Laravel 5.4 (or newer) [up and
running on your machine](https://laravel.com/docs/5.4#installing-laravel), clone
this repo wherever you'd like:

```
$ git clone https://github.com/paymentspring/phpaymentsprung.git
```

Before PHPaymentSprung will run correctly, you'll need to grab your
[PaymentSpring API keys](https://manage.paymentspring.com/account). Your unique
private and public key are used to validate API requests, so we'll need to set
these if we want our requests to work. The keys can be found at the bottom of
your account page on PaymentSpring's dashboard:

![PaymentSpring Account Tab Screenshot](/public/ACCOUNT.png?raw-true "PaymentSpring API Key Screenshot")

![PaymentSpring API Key Screenshot](/public/API_KEY.png?raw=true "PaymentSpring API Key Screenshot")

If you don't have a PaymentSpring account yet, [what are you waiting
for](https://paymentspring.com/signup/)? It's free! You can even use your
  sandbox account.

**Note: you may need to regenerate your keys, as your private API key is only
shown upon generation for security purposes.**

We store these keys in Laravel's `.env` file. By default, Laravel includes
`.env` in `.gitignore`, meaning that you'll need to add it yourself. The
simplest way to go about this is to rename `.env.example` to `.env`. The only
modification you should need to make is to insert your API keys at the bottom of
the file:

```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=

PAYMENTSPRING_PRIVATE_KEY=12345678 <-- Place your private key here (no quotes)
PAYMENTSPRING_PUBLIC_KEY=87654321 <-- Place your public key here (no quotes)
```

Next we'll run a Composer install to make sure all our dependencies are
downloaded. Make sure you're in the root directory of the project and run
`composer install`. You'll also want to set your application key to a random
string. To do this, run `php artisan key:generate`, which will update the key in
your `.env` file. Since we don't have any database interactions to worry about,
you shouldn't need to update any other fields in the `.env` file.

Phew! With that configuration out of the way, we can go ahead and run the
application. From the root directory of PHPaymentSprung, run `php artisan
serve`. If all goes well, you should be able to point your web browser at
`localhost:8000` and see the PHPaymentSprung landing page.

## Basic Flow and Tokenization

PaymentSpring uses tokens to protect customer PAN data (credit card numbers,
account numbers, and so on). This way, sensitive customer information never
touches your server, and thus, there is one less vector of attack for malicoius
actors.

**So what's a token?**

A token is just an ID, for example, `"2a89ef8a"` that corresponds to an
encrypted payment method stored on our server. You can use tokens both for
one-time charges and to create a customer (whom you could charge multiple times,
or sign up for a billing plan).

This way, you never store customer payment methods on your server and you don't
have to worry about securely encrypting customer payment information.

Here's an example of how it works:

1. A user on your site wants to sign up and become a customer. They click to go
   to the relevant sign-up page.
2. As part of the sign-up process, they are asked to provide a payment method by
   filling out a form.
3. When they click "Next", javascript (on your site) submits the payment
   information to the [token
   creation endpoint](https://paymentspring.com/developers/#create-a-token)
   using your public API key. We encrypt (using bank-grade encryption) that
   payment information on our server.
4. You get back a token, which is just a string (like `"24daa814b0"`) that
   corresponds to this payment method. You can store this token on your server
   if you like -- if someone were to hack it (or otherwise obtain it
   maliciously), they couldn't do anything useful or meaningful with this
   token.
5. When your user clicks "Submit" to sign up, this information gets passed to
   your server (probably) along with the token from Step 4, and you provide that
   token instead of a card number (etc.). We create the customer on our server
   with that token, and give you back a customer ID, which you can store on your
   server.

You can see the tokenization process in action in PHPaymentSprung through the
"Charge a Card" endpoint:

The [form for charging a
card](https://github.com/paymentspring/phpaymentsprung/blob/master/resources/views/charges/card.blade.php)
includes the relevant Javascript, which is a combination of these two files:

```php
<script type="text/javascript" src="https://paymentspring.com/js/paymentspring.js"></script>
<script type="text/javascript" src="{{ asset('js/charge.js') }}"></script>
```

The [`paymentspring.js` file](https://paymentspring.com/js/paymentspring.js) handles a lot of our tokenization for us, which we
use specifically in this line of code:

```javascript
paymentspring.generateToken(public_key, card_number, csc, card_holder, exp_month, exp_year, callback);
```

If you'd rather write your own JS tokenizer, the easiest way by far is to hit
our [JSONP tokenization
endpoint](https://paymentspring.com/developers/#create-a-token-with-jsonp).

The
[`charge.js`](https://github.com/paymentspring/phpaymentsprung/blob/master/public/js/charge.js)
script handles the exact behavior on the page, including any and all DOM
manipulation that might need to happen, and makes use of the result of
tokenization. The `$.ajax` call is what interacts with the Laravel server
itself.

## Integrating PaymentSpring into Your Laravel Sites

We designed PHPaymentSprung as an example of how to integrate the PaymentSpring
API into Laravel apps. Most of the functions in PHPaymentSprung have the same,
easy-to-implement process. To demonstrate this, we'll run through one of the
requests: Creating a Customer.

First, we'll take a look at the CustomersController, which handles requests
dealing with Customers. Go ahead and open
`app/Http/Controllers/CustomersController.php`. The function we are concerned
with in this case is `create`:

```PHP
// Takes form params and sends request to PaymentSpring API to create a customer.
public function create()
{
    // split date
    try {
        $date = explode('/', request('card_exp'));
        $month = $date[0];
        $year = $date[1];
    } catch (ErrorException $e) {
        dd("Error: Date needs to be valid and in format MM/YYYY");
    }

    // define params
    $body = [
        "company" => request('company'),
        "first_name" => request('first_name'),
        "last_name" => request('last_name'),
        "address_1" => request('address_1'),
        "address_2" => request('address_2'),
        "city" => request('city'),
        "state" => request('state'),
        "zip" => request('zip'),
        "phone" => request('phone'),
        "fax" => request('fax'),
        "website" => request('website'),
        "card_number" => request('card_number'),
        "card_exp_month" => $month,
        "card_exp_year" => $year,
    ];

    // create request
    $client = new Client();

    try {
        $response = $client->post('https://api.paymentspring.com/api/v1/customers', [
            'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), ''], 'body' => json_encode($body)]);
    } catch (TransferException $e) {
        dd($e->getMessage());
    }
    // get status and render response
    dd($response->getBody()->getContents());
}
```
Let's break down this method into smaller pieces. First, we split the date parameter:

```PHP
// split date
try {
    $date = explode('/', request('card_exp'));
    $month = $date[0];
    $year = $date[1];
} catch (ErrorException $e) {
    dd("Error: Date needs to be valid and in format MM/YYYY");
}
```

It's important to know that all the parameters here are being gathered from the
form in `resources/views/customers/new.blade.php`. We access the form inputs
through the `request()` function. The date field is a little tricky since
PaymentSpring's API prefers month and day separated. We could have easily made
two separate input fields in the form, but this felt like a good demonstration
of some behind-the-scenes logic possible with Laravel. Moving on, we define our
parameters:

 ```PHP
// define params
$body = [
    "company" => request('company'),
    "first_name" => request('first_name'),
    "last_name" => request('last_name'),
    "address_1" => request('address_1'),
    "address_2" => request('address_2'),
    "city" => request('city'),
    "state" => request('state'),
    "zip" => request('zip'),
    "phone" => request('phone'),
    "fax" => request('fax'),
    "website" => request('website'),
    "card_number" => request('card_number'),
    "card_exp_month" => $month,
    "card_exp_year" => $year,
];

 ```

This sets up an associative array with the [keys that the PaymentSpring API
expects](https://paymentspring.com/developers/#create-a-customer) being paired
to the value from the form in `resources/views/customers/new.blade.php`. The
names of the input fields in the form closely match the PaymentSpring API, with
the notable exception of the date that we split earlier. Finally, we send the
request:

```PHP
// create request
$client = new Client();

try {
    $response = $client->post('https://api.paymentspring.com/api/v1/customers', [
        'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), ''], 'body' => json_encode($body)]);
} catch (TransferException $e) {
    dd($e->getMessage());
}
// get status and render response
dd($response->getBody()->getContents());
```

There's quite a bit going on here! Let's look at each piece.

To handle sending the request, we use
[Guzzle](http://docs.guzzlephp.org/en/latest/). First, we create a new Guzzle
client. Then, we create a response by calling that client's post method. We
supply a link to the PaymentSpring API (notice how we are using `/customers`
since we are creating a new customer). Per the [Guzzle
Documentation](http://docs.guzzlephp.org/en/latest/quickstart.html#making-a-request),
we supply the merchant's private key as part of `'auth'` and send the body as a
json-encoded string of the `$body` array we defined earlier. This returns a
response, which we then `dd()` (dump and die) to the user. We could render a
prettier view if we wanted, but this gets the point across!

## Next Steps

If you are interested in integrating the PaymentSpring API into
your site, take a look at some of the other methods on the sample app as well;
they implement similar functionality. If you still have any questions or
feedback about using the API, [drop us a
line](https://paymentspring.com/contact/). We'd love to hear from you!
