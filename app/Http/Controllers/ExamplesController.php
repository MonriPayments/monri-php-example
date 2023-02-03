<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Monri\Exception\MonriException;

class ExamplesController extends BaseController
{

    /**
     * @throws MonriException
     * @throws \Exception
     */
    function createAndConfirmPayment()
    {
        $client = $this->setupMonri();
        $customer = $client->customers()->findByMerchantId('test-php-sdk-monri-com');
        $params = [
            'order_number' => "" . random_int(100000, 999999),
            'currency' => 'EUR',
            'amount' => 1000,
            'transaction_type' => 'purchase',
            'customer_uuid' => $customer->getId()
        ];
        $createResponse = $client->payments()->create($params);
        return view('create-and-confirm-payment', [
            'authenticityToken' => $client->getAuthenticityToken(),
            'clientSecret' => $createResponse->getClientSecret()
        ]);
    }

    /**
     * @throws MonriException
     */
    function confirmPaymentWithToken(Request $request)
    {
        $client = $this->setupMonri();
        return view('confirm-payment-with-token', [
            'authenticityToken' => $client->getAuthenticityToken(),
            'clientSecret' => $request->input('client_secret'),
            'token' => $request->input('token'),
        ]);
    }

    /**
     * @throws MonriException
     * @throws \Exception
     */
    function confirmPayment()
    {
        $client = $this->setupMonri();
        $params = [
            'order_number' => "" . random_int(100000, 999999),
            'currency' => 'EUR',
            'amount' => 1000,
            'transaction_type' => 'purchase'
        ];
        $createResponse = $client->payments()->create($params);
        return view(
            'confirm-payment',
            [
                'authenticityToken' => $client->getAuthenticityToken(),
                'clientSecret' => $createResponse->getClientSecret()
            ]
        );
    }

    /**
     * @throws MonriException
     * @throws \Exception
     */
    function savedCardPaymentCvvComponent()
    {
        $client = $this->setupMonri();
        $params = [
            'order_number' => "" . random_int(100000, 999999),
            'currency' => 'EUR',
            'amount' => 1000,
            'transaction_type' => 'purchase'
        ];
        $createResponse = $client->payments()->create($params);
        $customer = $client->customers()->findByMerchantId('test-php-sdk-monri-com');
        $paymentMethods = $client->customers()->customer($customer->getId())->paymentMethods();
        return view(
            'saved-card-payment-cvv-component',
            [
                'authenticityToken' => $client->getAuthenticityToken(),
                'clientSecret' => $createResponse->getClientSecret(),
                'paymentMethods' => $paymentMethods->getData()
            ]
        );
    }

    /**
     * @throws MonriException
     */
    function customer(Request $request)
    {
        $client = $this->setupMonri();
        $id = $request->route('id');
        $customer = $client->customers()->findByMerchantId($id);
        $paymentMethods = $client->customers()->customer($customer->getId())->paymentMethods();
        return view(
            'customer',
            [
                'customer' => $customer,
                'paymentMethods' => $paymentMethods->getData()
            ]
        );
    }

    /**
     * @throws MonriException
     */
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
