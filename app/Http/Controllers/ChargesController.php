<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use ErrorException;

class ChargesController extends Controller
{
    // Charges a card using a generated token
    public function chargeCard()
    {
        // Split date
        try {
            $date = explode('/', request('expiration_date'));   
            $month = $date[0];
            $year = $date[1];
        } catch (ErrorException $e) {
            dd("Error: Date needs to be valid and in format MM/YYYY");
        }

        // Create body for tokenization
        $body = [
            "token_type" => 'credit_card',
            "card_owner_name" => request('card_owner_name'),
            "card_number" => request('card_number'),
            "card_exp_month" => $month,
            "card_exp_year" => $year,
            "csc" => request('csc'),
        ];

        // Generate token
        $tokenID = $this->tokenize($body);

        // Create body for charge
        $parameters = [
            "token" => $tokenID,
            "amount" => $this->toCents(request('amount')),
        ];

        // Create and send request
        $client = new Client();

        try {
            $response = $client->post('https://api.paymentspring.com/api/v1/charge', [
                'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), ''], 'body' => json_encode($parameters)]);
        } catch (TransferException $e) {
            dd($e->getMessage());
        }
        dd($response->getBody()->getContents());
    }

    // Charges a bank account using a generated token
    public function chargeBank()
    {
        // Create body for tokenization
        $body = [
            "token_type" => 'bank_account',
            "bank_account_number" => request('bank_account_number'),
            "bank_routing_number" => request('bank_routing_number'),
            "bank_account_holder_first_name" => request('bank_account_holder_first_name'),
            "bank_account_holder_last_name" => request('bank_account_holder_last_name'),
            "bank_account_type" => request('bank_account_type'),
        ];

        // Generate token
        $tokenID = $this->tokenize($body);

        // Create body for charge
        $parameters = [
            "token" => $tokenID,
            "amount" => $this->toCents(request('amount')),
        ];

        // Create and send request
        $client = new Client();

        try {
            $response = $client->post('https://api.paymentspring.com/api/v1/charge', [
                'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), ''], 'body' => json_encode($parameters)]);
        } catch (TransferException $e) {
            dd($e->getMessage());
        }
        dd($response->getBody()->getContents());
    }

    // Generates a token to be used with a card or bank charge
    public function tokenize($body)
    {
        //Create and send request
        $client = new Client();

        try {
            $response = $client->post('https://api.paymentspring.com/api/v1/tokens', [
                'auth' => [env('PAYMENTSPRING_PUBLIC_KEY'), ''], 'body' => json_encode($body)]);
        } catch (TransferException $e) {
            dd($e->getMessage());
        }
        
        //Get token id
        $json = json_decode($response->getBody(), true);
        return $json['id'];
    }
}
