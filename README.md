# PHPaymentSprung

PHPaymentSprung is a sample app demonstrating PaymentSpring's API interacting with the Laravel PHP framework.

## Getting Started

PHPaymentSprung was created using Laravel 5.4. Running it with older versions may lead to unexpected results! To start, clone this repo wherever you'd like:

`git clone https://github.com/paymentspring/phpaymentsprung.git`

Before PHPaymentSprung will run correctly, you'll need to grab your [PaymentSpring API keys](https://manage.paymentspring.com/account), which can be found at the bottom of your account page on PaymentSpring's dashboard. If you don't have a PaymentSpring account yet, [what are you waiting for](https://paymentspring.com/signup/)? It's free!

**Note: you may need to regenerate your keys, as your private API key is only shown upon generation for security purposes.**

We store these keys in Laravel's `.env` file. By default, Laravel includes `.env` in `.gitignore`, meaning that you'll need to add it yourself. The simplest way to go about this is to rename `.env.example` to `.env`. The only modification you should need to make is to insert your API keys at the bottom of the file:
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

PRIVATE_KEY=12345678 <-- Place your private key here (no quotes)
PUBLIC_KEY=87654321 <-- Place your public key here (no quotes)
```

Next we'll run a Composer install to make sure all our dependencies are downloaded. Make sure you're in the root directory of the project and run `composer install`. You'll also want to set your application key to a random string. To do this, run `php artisan key:generate`, which will update the key in your `.env` file. Since we don't have any database interactions to worry about, you shouldn't need to update any other fields in the `.env` file.

Phew! With that configuration out of the way, we can go ahead and run the application. From the root directory of PHPaymentSprung, run `php artisan serve`. If all goes well, you should be able to point your web browser at `localhost:8000` and see the PHPaymentSprung landing page.

## Integrating PaymentSpring into Your Laravel Sites

We designed PHPaymentSprung as an example of how to integrate the PaymentSpring API into Laravel apps. Most of the functions in PHPaymentSprung have the same, easy-to-implement process. To demonstrate this, we'll run through one of the requests: Creating a Customer.

First, we'll take a look at the CustomersController, which handles requests dealing with Customers. Go ahead and open `app/Http/Controllers/CustomersController.php`. The function we are concerned with in this case is `create`:
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
            'auth' => [env('PRIVATE_KEY'), ''], 'body' => json_encode($body)]);
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
 It's important to know that all the parameters here are being gathered from the form in `resources/views/customers/new.blade.php`. We access the form inputs through the `request()` function. The date field is a little tricky since PaymentSpring's API prefers month and day separated. We could have easily made two separate input fields in the form, but this felt like a good demonstration of some behind-the-scenes logic possible with Laravel. Moving on, we define our parameters:
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
This sets up an associative array with the [keys that the PaymentSpring API expects](https://paymentspring.com/developers/#create-a-customer) being paired to the value from the form in `resources/views/customers/new.blade.php`. The names of the input fields in the form closely match the PaymentSpring API, with the notable exception of the date that we split earlier. Finally, we send the request:
```PHP
// create request
$client = new Client();

try {
    $response = $client->post('https://api.paymentspring.com/api/v1/customers', [
        'auth' => [env('PRIVATE_KEY'), ''], 'body' => json_encode($body)]);
} catch (TransferException $e) {
    dd($e->getMessage());
}
// get status and render response
dd($response->getBody()->getContents());
```
There's quite a bit going on here! Let's look at each piece. 

To handle sending the request, we use [Guzzle](http://docs.guzzlephp.org/en/latest/). First, we create a new Guzzle client. Then, we create a response by calling that client's post method. We supply a link to the PaymentSpring API (notice how we are using `/customers` since we are creating a new customer). Per the [Guzzle Documentation](http://docs.guzzlephp.org/en/latest/quickstart.html#making-a-request), we supply the merchant's private key as part of `'auth'` and send the body as a json-encoded string of the `$body` array we defined earlier. This returns a response, which we then `dd()` (dump and die) to the user. We could render a prettier view if we wanted, but this gets the point across!

## Next Steps
If you are interested in integrating the PaymentSpring API into your site, take a look at some of the other methods on the sample app as well; they implement similar functionality. If you still have any questions or feedback about using the API, [drop us a line](https://paymentspring.com/contact/). We'd love to hear from you!