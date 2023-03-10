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
<div id="payment-component-element"></div>
<div id="card-errors"></div>
<input type="button" name="button" id="pay-btn" value="Pay">
<script>
    var monri = Monri('{{$authenticityToken}}');
    var components = monri.components({"clientSecret": '{{$clientSecret}}'});
    // Create an instance of the card Component.
    var paymentComponent = components.create('payment', {});
    // Add an instance of the card Component into the `card-element` <div>.
    paymentComponent.mount('payment-component-element');
    paymentComponent.setActivePaymentMethod("{{$token}}")
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

        monri.confirmPayment(paymentComponent, transactionParams).then(result => {
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
</script>
</body>
</html>
