<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Response;
use ErrorException;

class ChargesController extends Controller
{
  // Charges a card using a generated token
  public function newCharge()
  {
    // If the token was not created successfully, we grab the response here and send it back to the view
    if (array_key_exists('errors', $_POST['params']['token'])) {
      return Response::json(['code' => $_POST['params']['token']['errors'][0]['code'], 'message' => $_POST['params']['token']['errors'][0]['message']], 500);
    }
    // Create body for charge
    $parameters = [
      "token" => $_POST['params']['token']['id'],
      "amount" => $this->toCents($_POST['params']['amount']),
    ];

    // Create and send request
    $client = new Client();

    try {
      $response = $client->post('https://api.paymentspring.com/api/v1/charge', [
        'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), ''], 'body' => json_encode($parameters)]);
    } catch (TransferException $e) {
      // If guzzle has a problem posting the charge, we grab the error message and display it to the user
      return Response::json(['code' => '', 'message' => $e->getMessage()], 400);
    }
    return $response->getBody()->getContents();
  }
}
