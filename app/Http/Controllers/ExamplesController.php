<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ExamplesController extends BaseController
{

    function createAndConfirmPayment()
    {
        $client = $this->setupMonri();
        $customer = $client->customers()->create(
            [
                'email' => 'test-php-sdk@monri.com',
                'name' => 'Name',
                'merchant_customer_id' => 'test-php-sdk-monri-com'
            ]
        );
        $params = [
            'order_number' => "" . random_int(100000, 999999),
            'currency' => 'EUR',
            'amount' => 1000,
            'transaction_type' => 'purchase',
            'customer_uuid' => $customer->getId(),
            'merchant_customer_uuid' => 'test-php-sdk-monri-com'
        ];
        $createResponse = $client->payments()->create($params);
        return view('create-and-confirm-payment', [
            'authenticityToken' => $client->getAuthenticityToken(),
            'clientSecret' => $createResponse->getClientSecret()
        ]);
    }

    function confirmPaymentWithToken(Request $request)
    {
        $client = $this->setupMonri();
        return view('confirm-payment-with-token', [
            'authenticityToken' => $client->getAuthenticityToken(),
            'clientSecret' => $request->input('client_secret'),
            'token' => $request->input('token'),
        ]);
    }

    function confirmPayment()
    {
        $client = $this->setupMonri();
        $createResponse = $client->payments()->create(['order_number' => "" . random_int(100000, 999999), 'currency' => 'EUR', 'amount' => 1000, 'transaction_type' => 'purchase']);
        return view(
            'confirm-payment',
            [
                'authenticityToken' => $client->getAuthenticityToken(),
                'clientSecret' => $createResponse->getClientSecret()
            ]
        );
    }

    function customer(Request $request)
    {
        $client = $this->setupMonri();
        $id = $request->route('id');
        $customer = $client->customers()->find($id);
        $paymentMethods = $client->customers()->paymentMethods($id);
        return view(
            'customer',
            [
                'customer' => $customer,
                'paymentMethods' => $paymentMethods->getData()
            ]
        );
    }

    private function setupMonri(): \Monri\Client
    {
        $config = new \Monri\Config();
        // production
        $config->setEnvironment('test');
        $config->setMerchantKey('TestKeyXULLyvgWyPJSwOHe');
        $config->setAuthenticityToken('6a13d79bde8da9320e88923cb3472fb638619ccb');
        return new \Monri\Client($config);
    }
}
