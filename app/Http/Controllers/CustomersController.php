<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use ErrorException;

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
