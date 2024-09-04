<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\ContestImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\PaymentIntent;

class TestController extends Controller
{
    public function create()
    {
        // Vérifier si l'utilisateur est connecté et a l'email spécifié
        if (Auth::check() && Auth::user()->email === 'desch.ryann@gmail.com') {
            return view('create');
        } else {
            // Rediriger l'utilisateur vers une autre page avec un message d'erreur
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
    }

    public function store(Request $request)
    {
        // Vérifier si l'utilisateur est connecté et a l'email spécifié
        if (Auth::check() && Auth::user()->email === 'desch.ryann@gmail.com') {
            // Validation des données
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'entry_fee' => 'required|numeric',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Création du concours
            $contest = Contest::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'entry_fee' => $request->input('entry_fee'),
            ]);

            // Gestion des images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('contests', 'public');
                    ContestImage::create([
                        'contest_id' => $contest->id,
                        'image_path' => $path,
                    ]);
                }
            }

            return redirect()->route('dashboard')->with('success', 'Contest created successfully!');
        } else {
            // Rediriger l'utilisateur vers une autre page avec un message d'erreur
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
    }

    public function show($id)
    {
        // Vérifier si l'utilisateur est connecté et a l'email spécifié
        if (Auth::check() && Auth::user()->email === 'desch.ryann@gmail.com') {
            $contest = Contest::with('images')->findOrFail($id);
            return view('contests.show', compact('contest'));
        } else {
            // Rediriger l'utilisateur vers une autre page avec un message d'erreur
            return redirect()->route('dashboard')->with('error', 'Unauthorized access.');
        }
    }

    public function participate($id)
    {
        $contest = Contest::findOrFail($id);

        if ($contest->reserveSlot()) {
            return redirect()->back()->with('success', 'You have successfully entered the contest!');
        }

        return redirect()->back()->with('error', 'No available slots left for this contest.');
    }

    public function showPaymentForm($id)
    {
        $contest = Contest::findOrFail($id);
        return view('contests.pay', compact('contest'));
    }

    public function createCheckoutSession(Request $request, $id)
    {
        $contest = Contest::findOrFail($id);

        // Configurez Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Créez une session de paiement
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $contest->name,
                    ],
                    'unit_amount' => $contest->entry_fee * 100, // Montant en centimes
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('contests.thankYou'),
            'cancel_url' => route('contests.show', $contest->id),
        ]);

        // Redirigez l'utilisateur vers la session de paiement Stripe
        return redirect($session->url);
    }

    public function paymentRedirect($clientSecret)
    {
        // Page de redirection pour le paiement
        return view('contests.redirect', compact('clientSecret'));
    }

    public function createPaymentIntent($id)
    {
        $contest = Contest::findOrFail($id);

        // Configurez Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Créez un PaymentIntent
        $paymentIntent = PaymentIntent::create([
            'amount' => $contest->entry_fee * 100, // Montant en centimes
            'currency' => 'eur',
            'payment_method_types' => ['card'],
            'metadata' => ['contest_id' => $contest->id],
        ]);

        return response()->json(['clientSecret' => $paymentIntent->client_secret]);
    }

}
