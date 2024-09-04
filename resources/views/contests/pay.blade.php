<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | Dream Trips</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        #card-element {
            background: white;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .card-errors {
            color: red;
        }
    </style>
</head>
<body>
<x-app-layout>
    <div class="container mt-4">
        <div class="card mx-auto" style="max-width: 99%;">
            <div class="card-header text-center">
                <h1 class="mb-0">{{ $contest->name }}</h1>
            </div>
            <div class="card-body text-center">
                <form id="payment-form">
                    <div id="card-element"></div>
                    <button type="submit" class="btn btn-primary mt-3">Pay and Participate</button>
                    <div id="error-message" class="card-errors mt-3"></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const stripe = Stripe('{{ config('services.stripe.key') }}');
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');

            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const { clientSecret } = await fetch('{{ route('contests.createPaymentIntent', $contest->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                }).then(response => response.json());

                const { error } = await stripe.confirmCardPayment(clientSecret, {
                    payment_method: {
                        card: cardElement,
                    },
                });

                if (error) {
                    document.getElementById('error-message').textContent = error.message;
                } else {
                    window.location.href = '{{ route('contests.thankYou') }}';
                }
            });
        });
    </script>
</x-app-layout>
</body>
</html>
