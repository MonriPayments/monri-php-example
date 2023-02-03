<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ipgtest.monri.com/dist/components.js"></script>
</head>
<body class="antialiased">
<div>

    <p></p>
    <ul>
        @foreach($paymentMethods as $paymentMethod)
            <li>id: {{ $paymentMethod->getId()}}</li>
        @endforeach
    </ul>
</div>
</body>
</html>
