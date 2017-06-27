<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Response;
use ErrorException;

class CustomersController extends Controller
{
  public function index()
  {
    $client = new Client();
    try {
      $response = $client->get('https://api.paymentspring.com/api/v1/customers', [
        'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), '']]);
    } catch(TransferException $e) {
      dd($e->getMessage());
    }

    // The json_decode call takes the response and returns an associative array that is used in the index view.
    $body = json_decode($response->getBody(), true);
    return view('customers.index', ['body' => $body]);
  }

  // Takes form params and sends request to PaymentSpring API to create a customer.
  public function create() {
    // If the token was not created successfully, we grab the response here and send it back to the view
    if (array_key_exists('errors', $_POST['params']['token'])) {
      return Response::json(['code' => $_POST['params']['token']['errors'][0]['code'],
        'message' => $_POST['params']['token']['errors'][0]['message']], 500);
    }
    // define params
    $body = [
      "token" => $_POST['params']['token']['id']
    ];

    // create request
    $client = new Client();

    try {
      $response = $client->post('https://api.paymentspring.com/api/v1/customers', [
        'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), ''],
        'json' => $body]);
    } catch (TransferException $e) {
      return Response::json(['code' => '', 'message' => $e->getMessage()], 400);
    }
    // get status and render response
    // TODO: For whatever reason, we get back content in application/html
    //  instead of application/json, and I'm not sure how to coerce it correctly.
    dd(json_decode($response->getBody()->getContents(), true));
  }

  // Takes a search query and returns list of customers.
  public function search()
  {
    // define params
    $body = [
      "search_term" => request('search_term'),
    ];

    // create request
    $client = new Client();

    try {
      $response = $client->post('https://api.paymentspring.com/api/v1/customers/search', [
        'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), ''], 'body' => json_encode($body)]);
    } catch (TransferException $e) {
      dd($e->getMessage());
    }
    // The json_decode call takes the response and returns an associative array that is used in the search results.
    $body = json_decode($response->getBody(), true);
    return view('customers.results', ['body' => $body]);
  }
}
