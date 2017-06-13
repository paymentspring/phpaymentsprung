<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class PlansController extends Controller
{
    public function new()
    {
        // Define params
        $body = [
            "frequency" => request('frequency'),
            "name" => request('name'),
            "amount" => $this->toCents(request('amount')),
            "day" => request('day'),
        ];

        // Create and send request
        $client = new Client();
        
        try {
            $response = $client->post('https://api.paymentspring.com/api/v1/plans', [
                'auth' => [env('PAYMENTSPRING_PRIVATE_KEY'), ''], 'body' => json_encode($body)]);
        } catch (TransferException $e) {
            dd($e->getMessage());
        }
        dd($response->getBody()->getContents());
    }
}
