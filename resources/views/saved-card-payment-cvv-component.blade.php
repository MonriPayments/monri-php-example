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
<ul>
    @foreach($paymentMethods as $paymentMethod)
        <li id="{{$paymentMethod->getId()}}" onclick="selectPaymentMethod(this)">maskedPan: {{$paymentMethod->getMaskedPan()}}</li>
    @endforeach
</ul>
<div id="cvv-component-element"></div>
<div id="card-errors"></div>
<input type="button" name="button" id="pay-btn" value="Pay">
<script>
    var monri = Monri('{{$authenticityToken}}');
    var components = monri.components({"clientSecret": '{{$clientSecret}}'});
    // Create an instance of the card Component.
    var cvvComponent = components.create('cvv', {});
    cvvComponent.mount('cvv-component-element');
    document.getElementById('pay-btn').addEventListener('click', function () {
        const transactionParams = {
            address: "Adresa",
            fullName: "Test Test",
            city: "Sarajevo",
            zip: "71000",
            phone: "+38761000111",
            country: "BA",
            email: "tester-php-sdk@monri.com",
            orderInfo: "Confirm payment with token"
        }

        monri.confirmPayment(cvvComponent, transactionParams).then(result => {
            if (result.error) {
                // Inform the customer that there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                const paymentResult = result.result;
                if (paymentResult.status === 'approved') {
                    alert("Transaction approved")
                } else {
                    alert("Transaction declined")
                }
            }
        })
    })

    function selectPaymentMethod(e) {
        cvvComponent.setActivePaymentMethod(e.getAttribute('id'))
    }

</script>
</body>
</html>
