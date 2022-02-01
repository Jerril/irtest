<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Customer;
use App\Http\Requests\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response()->json([
        //     'data' => [

        //     ]
        // ])
        
        return response()->json(Customer::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Get the form submission
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name'=>'required',
            'email'=>'required'
        ]);

        $customer = Customer::create($request->all());
        
        return response()->json([
            "data" => [
                "name" => $customer->name,
                "email" => $customer->email
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, $id)
    {
        //
        $customer = Customer::FindOrFail($id);

        return response()->json([
            'data' => [
                "name" => $customer->name,
                "email" => $customer->email,
                "transactions" => []
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }


    // Encrypt request payload
    public function encrypt($data, $key){
        $encData = openssl_encrypt($data, 'DES-EDE3', $key, OPENSSL_RAW_DATA);
        $client = base64_encode($encData);

        return $client;
    }

    // Charge Customers card
    public function charge(Request $request, $id)
    {   
        // 1. Collect payment details from customer
        // 2. Encrypt payment details
        $flw_encrypt_key = 'FLWSECK_TEST264d3651216e';
        $client = $this->encrypt($request, $flw_encrypt_key);

        return $client;
        // 3. Initiate payment
        $response = Http::withToken('FLWSECK_TEST-SANDBOXDEMOKEY-X')->acceptJson()->post('https://api.flutterwave.com/v3/charges?type=card', ["client"=>$client]);
        // 4. Get response


        // $request->tx_ref = time();
        // $request->type = "card";

        // return response()->json([
        //     'request' => $request->getContent()
        // ]);

        // Call the flutterwave API to debit
        // $response = Http::withHeaders([
        //     'Accept' => 'application/json',
        //     'Authorization' => 'Bearer FLWSECK_TEST-SANDBOXDEMOKEY-X',
        //     'Content-Type' => 'application/json',
        // ])->post('https://api.flutterwave.com/v3/charges?type=card', ["client"=>$client]);

        // $response = Http::withToken('FLWSECK_TEST-SANDBOXDEMOKEY-X')->acceptJson()->post('https://api.flutterwave.com/v3/charges?type=card', ["client"=>$client]);

        // $response = $client->request('POST', 'https://api.flutterwave.com/v3/charges?type=card', [
        // 'body' => '{"amount":100,"currency":"NGN","card_number":5399670123490229,"cvv":123,"expiry_month":1,"expiry_year":21,"email":"user@flw.com","tx_ref":"MC-3243e","phone_number":"07033002245","fullname":"Yemi Desola","preauthorize":false,"redirect_url":"https://webhook.site/3ed41e38-2c79-4c79-b455-97398730866c","client_ip":"154.123.220.1","device_fingerprint":"62wd23423rq324323qew1","meta":{"flightID":"123949494DC","sideNote":"This is a side note to track this call"},"authorization":{"mode":"pin","pin":2245,"city":"San Francisco","address":"333 Fremont Street, San Francisco, CA","state":"California","country":"US","zipcode":94105},"payment_plan":"12345"}',
        // 'headers' => [
        //     'Accept' => 'application/json',
        //     'Authorization' => 'Bearer FLWSECK_TEST-SANDBOXDEMOKEY-X',
        //     'Content-Type' => 'application/json',
        // ],
        // ]);

        return $response;

        // Save the transaction details to table if successful
    }

    public function completeTransaction($client){
        return "this will complete transaction";
    }
}
