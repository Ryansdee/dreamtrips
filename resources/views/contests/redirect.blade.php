<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting to Payment</title>
    <style>
        /* Styles CSS */
    </style>
</head>
<body>
    <h1>Redirecting to Payment</h1>
    <p>Please wait while we redirect you to the payment page...</p>
    <script>
        // Effectuez une redirection automatique vers Stripe
        window.location.href = `https://checkout.stripe.com/pay/${'{{ $clientSecret }}'}`;
    </script>
</body>
</html>
