<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Http\Requests\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        return "worked";

        // Validate input
        $request->validate([
            'card_number' => 'required',
            'cvv' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'email' => 'required',
            'tx_ref' => 'required',
            'fullname' => '',
            'redirect_url' => ''
        ]);

        $request->email = $request->input('email', Customer::find($id)->email);
        $request->fullname = $request->input('fullname', Customer::find($id)->name);
        $request->tx_ref = time();

        // Call the flutterwave API to debit
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer FLWSECK_TEST-SANDBOXDEMOKEY-X',
            'Content-Type' => 'application/json',
        ])->post('https://api.flutterwave.com/v3/charges?type=card', $request->all());

        // $response = $client->request('POST', 'https://api.flutterwave.com/v3/charges?type=card', [
        // 'body' => '{"amount":100,"currency":"NGN","card_number":5399670123490229,"cvv":123,"expiry_month":1,"expiry_year":21,"email":"user@flw.com","tx_ref":"MC-3243e","phone_number":"07033002245","fullname":"Yemi Desola","preauthorize":false,"redirect_url":"https://webhook.site/3ed41e38-2c79-4c79-b455-97398730866c","client_ip":"154.123.220.1","device_fingerprint":"62wd23423rq324323qew1","meta":{"flightID":"123949494DC","sideNote":"This is a side note to track this call"},"authorization":{"mode":"pin","pin":2245,"city":"San Francisco","address":"333 Fremont Street, San Francisco, CA","state":"California","country":"US","zipcode":94105},"payment_plan":"12345"}',
        // 'headers' => [
        //     'Accept' => 'application/json',
        //     'Authorization' => 'Bearer FLWSECK_TEST-SANDBOXDEMOKEY-X',
        //     'Content-Type' => 'application/json',
        // ],
        // ]);

        echo $response->getBody();

        // Save the transaction details to table if successful
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransactionRequest  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
