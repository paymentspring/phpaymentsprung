<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class SubscriptionsController extends Controller
{
    public function new()
    {
        // Define params
        $body = [
            "id" => request('id'),
            "customer_id" => request('customer_id'),
            "ends_after" => request('ends_after'),
        ];

        // Create and send request
        $client = new Client();
        
        try {
            $response = $client->post('https://api.paymentspring.com/api/v1/plans/'.request('id').'//subscription/'.request('customer_id'), [
                'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), ''], 'body' => json_encode($body)]);
        } catch (TransferException $e) {
            dd($e->getMessage());
        }
        dd($response->getBody()->getContents());
    }
}
