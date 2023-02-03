<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="antialiased">
        <ul>
            <li><a href="/confirm-payment">Monri Components - Confirm Payment</a></li>
            <li><a href="/create-and-confirm-payment">Monri Components - Create Token and Confirm Payment</a></li>
            <li><a href="/saved-card-payment-cvv-component">Monri Components - Saved Card Payment + Cvv Component</a></li>
            <li><a href="/customer/test-php-sdk-monri-com">Customer</a></li>
        </ul>
    </body>
</html>
