<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ScrapeController;
use Illuminate\Support\Facades\Route;

// Routes pour les paiements
Route::post('/create-checkout-session', [PaymentController::class, 'createCheckoutSession'])->name('payment.create');
Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment-cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

// Routes pour les concours
Route::get('/contests', [TestController::class, 'index'])->name('contests.index');
Route::get('/contests/{id}', [TestController::class, 'show'])->name('contests.show');
Route::get('/create', [TestController::class, 'create'])->name('contests.create');
Route::post('/contests/store', [TestController::class, 'store'])->name('contests.store');
Route::post('/contests/{id}/payment-intent', [TestController::class, 'createPaymentIntent'])->name('contests.createPaymentIntent');
Route::post('/contests/{id}/create-checkout-session', [TestController::class, 'createCheckoutSession'])->name('contests.createCheckoutSession');
Route::get('/contests/thank-you', [TestController::class, 'thankYou'])->name('contests.thankYou');
Route::post('/contests/{id}/participate', [TestController::class, 'participate'])->name('contests.participate');
Route::post('/webhook/stripe', [TestController::class, 'handleWebhook']);

// Route pour la page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Route pour le tableau de bord
Route::get('/home', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/amazon', [DashboardController::class, 'amazon'])->middleware(['auth', 'verified'])->name('amazon');
Route::get('/apple', [DashboardController::class, 'apple'])->middleware(['auth', 'verified'])->name('apple');
Route::get('/greengo', [DashboardController::class, 'greengo'])->middleware(['auth', 'verified'])->name('greengo');


// Routes pour le profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/scrape-contest', [ScrapeController::class, 'scrape'])->name('scrape.contest');

// Auth Routes
require __DIR__.'/auth.php';
