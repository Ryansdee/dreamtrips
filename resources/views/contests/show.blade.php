@php
    function formatDescription($text) {
        // Remplacer les points, points d'exclamation, et deux-points par eux-mêmes suivis de <br> et un astérisque pour les deux-points
        $text = preg_replace('/([.!])\s*/', '$1<br>', $text);
        $text = preg_replace('/([:,])\s*/', '$1<br> *', $text);
        $text = str_replace('/*', '<strong>', $text);
        $text = str_replace('*/', '</strong>', $text);
        return $text;
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $contest->name }} | Dream Trips</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .carousel-item img {
            object-fit: cover;
            width: 400px;
            height: 500px; /* Adjust height as needed */
        }
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            padding: 1rem;
            border-bottom: 1px solid #ddd;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-footer {
            background-color: #f8f9fa;
            padding: 1rem;
            border-top: 1px solid #ddd;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 50%;
        }
    </style>
</head>
<body>
<x-app-layout>
    <div class="container mt-4">
        <div class="card mx-auto" style="max-width: 99%;">
            @if($contest->images->isNotEmpty())
                <!-- Carousel -->
                <div id="contestCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach($contest->images as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100" alt="Contest Image">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#contestCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#contestCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @else
                <p class="text-center mt-4">No images available for this contest.</p>
            @endif
            <div class="card-header text-center">
                <h1 class="mb-0">{{ $contest->name }}</h1>
            </div>
            <div class="card-body text-center">
                {!! formatDescription($contest->description) !!}
            </div>
            <div class="card-footer text-center">
                <p class="mb-0">Coût d'entrée: <strong>{{ $contest->entry_fee }}€</strong></p>
                <p class="mb-0">Places libres: <strong>{{ $contest->total_slots - $contest->occupied_slots }}</strong></p>
                @if($contest->hasAvailableSlots())
                    <form id="payment-form" method="POST">
                        @csrf
                        <div id="card-element">
                            <!-- Un champ de carte sera inséré ici. -->
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Pay and Participate</button>
                        <div id="error-message" class="mt-3"></div>
                    </form>
                @else
                    <p class="text-danger">No more slots available.</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const stripe = Stripe('{{ config('services.stripe.key') }}'); // Remplacez par votre clé publique Stripe
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');

            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                // Obtenez le client_secret du PaymentIntent
                const { clientSecret } = await fetch('{{ route('contests.createPaymentIntent', $contest->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                }).then(response => response.json());

                // Confirm the payment
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
