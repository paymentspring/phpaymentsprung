<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class CustomersController extends Controller
{
    public function index()
    {
        $client = new Client();
        $response = $client->get('https://api.paymentspring.com/api/v1/customers', [
            'auth' => [env('PRIVATE_KEY'), '']]);
        // The json_decode call takes the response and returns an associative array that is used in the index view.
        $body = json_decode($response->getBody(), true);
        return view('customers.index', ['body' => $body]);
    }

    // Takes form params and sends request to PaymentSpring API to create a customer.
    public function create()
    {
        // define params
        $body = [
            "company" => request('company'),
            "first_name" => request('first_name'),
            "last_name" => request('last_name'),
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
        $status = $response->getStatusCode();
        dd($status);
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
                'auth' => [env('PRIVATE_KEY'), ''], 'body' => json_encode($body)]);
        } catch (TransferException $e) {
            dd($e->getMessage());
        }
        // The json_decode call takes the response and returns an associative array that is used in the search results.
        $body = json_decode($response->getBody(), true);
        return view('customers.results', ['body' => $body]);
    }
}
