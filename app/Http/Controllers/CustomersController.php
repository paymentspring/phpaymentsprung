<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CustomersController extends Controller
{
    public function index()
    {
        $client = new Client();
        $response = $client->get('https://api.paymentspring.com/api/v1/customers', [
            'auth' => [env('PRIVATE_KEY'), '']]);
        $body = json_decode($response->getBody(), true);
        return view('customers.index', ['body' => $body]);
    }

    // Take form params and send request to PaymentSpring API to create a customer
    public function create()
    {
        // define params
        $body = [
            "company" => request('company'),
            "first_name" => request('first_name'),
            "last_name" => request('last_name'),
        ];
        $body = json_encode($body);

        // create request
        $client = new Client();

        try
        {
            $response = $client->post('https://api.paymentspring.com/api/v1/customers', [
                'auth' => [env('PRIVATE_KEY'), ''], 'body' => $body]);
        }

        catch (clientException $e)
        {
            dd($e->errorMessage());
        }

        // get status and render response
        $status = $response->getStatusCode();
        dd($status);
    }
}
