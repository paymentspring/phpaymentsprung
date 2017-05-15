<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChargesController extends Controller
{
    // Charges a card using a generated token
    public function card()
    {
        // Split date
        $date = explode('/', request('expiration_date'));
        $month = $date[0];
        $year = $date[1];

        // Create body for tokenization
        $body = [
            "token_type" => 'credit_card',
            "card_owner_name" => request('card_owner_name'),
            "card_number" => request('card_number'),
            "card_exp_month" => $month,
            "card_exp_year" => $year,
            "csc" => request('csc'),
        ];
        $body = json_encode($body);

        // Generate token
        $tokenID = $this->tokenize($body);

        // Create body for charge
        $parameters = [
            "token" => $tokenID,
            "amount" => $this->toCents(request('amount')),
        ];
        $parameters = json_encode($parameters);

        // Create and send request
        $client = new Client();
        $response = $client->post('https://api.paymentspring.com/api/v1/charge', [
            'auth' => [env('PRIVATE_KEY'), ''], 'body' => $parameters]);
        dd($response->getBody());
    }

    // Generates a token to be used with a card or bank charge
    public function tokenize($body)
    {
        //Create and send request
        $client = new Client();
        $response = $client->post('https://api.paymentspring.com/api/v1/tokens', [
            'auth' => [env('PUBLIC_KEY'), ''], 'body' => $body]);
        //Get token id
        $json = json_decode($response->getBody(), true);
        return $json['id'];
    }

    // The PaymentSpring API expects an integer representation in cents,
    // so we call this method before sending any amounts
    public function toCents($amount)
    {
        return bcmul($amount, 100);
    }
}
