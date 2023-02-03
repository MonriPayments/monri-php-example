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
<div id="card-element"></div>
<div id="payment-component-element"></div>
<form action="/confirm-payment-with-token" method="POST" id="confirm-payment-with-token-form">
    @csrf
    <input type="hidden" name="client_secret" value="{{$clientSecret}}">
    <input type="hidden" name="token" id="payment-token-input">
</form>
<input type="button" name="button" id="pay-btn" value="Continue to payment">
<script>
    var monri = Monri('{{$authenticityToken}}');
    var components = monri.components({"clientSecret": '{{$clientSecret}}'});
    // Create an instance of the card Component.
    var card = components.create('card', {
        tokenizePanOffered: true
    });
    // Add an instance of the card Component into the `card-element` <div>.
    card.mount('card-element');

    document.getElementById('pay-btn').addEventListener('click', function () {
        monri.createToken(card).then(result => {
            console.log(result)
            let input = document.getElementById('payment-token-input');
            input.value = result.result.id
            document.getElementById('confirm-payment-with-token-form').submit();
        })
    })
</script>
</body>
</html>
