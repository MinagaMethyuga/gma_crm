<?php

use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

// Checkout routes (public endpoints for Stripe redirects)
Route::controller(\App\Http\Controllers\CheckoutController::class)->group(function () {
    Route::get('/checkout/success', 'success')->name('checkout.success');
    Route::get('/checkout/cancel', 'cancel')->name('checkout.cancel');
});

// Stripe webhook (no CSRF, no auth)
Route::post('/stripe/webhook', [\App\Http\Controllers\StripeWebhookController::class, 'handle'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
    ->name('stripe.webhook');

// Public pages
Route::view('/', 'welcome')->name('home');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/who-we-serve', fn () => view('who-we-serve'))->name('who-we-serve');
Route::get('/committees', fn () => view('committees'))->name('committees');
Route::get('/research-insights', fn () => view('research-insights'))->name('research-insights');
Route::get('/events', fn () => view('events'))->name('events');
Route::get('/public-events', fn () => view('public_events'))->name('public-events');
Route::get('/pricing', fn () => view('pricing'))->name('pricing');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Checkout - create a payment
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');

    // Smart Dashboard Route
    Route::get('dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return view('dashboard');
        }
        return redirect()->route('member.dashboard');
    })->name('dashboard');

    // Admin-only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::view('members', 'members')->name('members');
        Route::view('admin-events', 'admin_events')->name('admin.events');
    });

    // Member dashboard (any authenticated user with member role)
    Route::view('/member/dashboard', 'member_dashboard')->name('member.dashboard');
    Route::view('/member/events', 'member_events')->name('member.events');
    Route::view('/paymentPage', 'paymentPage')->name('paymentPage');

    // Team invitation acceptance
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
});

require __DIR__.'/settings.php';
