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
Route::get('/events', fn () => view('public_events'))->name('events');
Route::get('/admin-events-legacy', fn () => view('events'))->name('events.legacy');
Route::get('/pricing', fn () => view('pricing', ['plans' => \App\Models\Plan::all()->keyBy('slug')]))->name('pricing');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Checkout - create a payment
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');

    // Smart Dashboard Route
    Route::get('dashboard', function () {
        if (auth()->user()->isAdmin()) {
            $activeMembers = \App\Models\User::where('role', \App\Enums\UserRole::Member)->count();
            $lastMonthMembers = \App\Models\User::where('role', \App\Enums\UserRole::Member)
                ->where('created_at', '<', now()->startOfMonth())->count();
                
            $memberGrowth = 0;
            if ($lastMonthMembers > 0) {
                $memberGrowth = round((($activeMembers - $lastMonthMembers) / $lastMonthMembers) * 100);
            } elseif ($activeMembers > 0) {
                $memberGrowth = 100;
            }

            $newSignups = \App\Models\User::where('role', \App\Enums\UserRole::Member)
                ->where('created_at', '>=', now()->startOfWeek())->count();

            $totalRevenueCents = \App\Models\Order::where('status', 'paid')->sum('amount');
            $lastMonthCents = \App\Models\Order::where('status', 'paid')
                ->where('created_at', '<', now()->startOfMonth())->sum('amount');

            $revenueGrowth = 0;
            if ($lastMonthCents > 0) {
                $revenueGrowth = round((($totalRevenueCents - $lastMonthCents) / $lastMonthCents) * 100);
            } elseif ($totalRevenueCents > 0) {
                $revenueGrowth = 100;
            }

            $dollars = $totalRevenueCents / 100;
            if ($dollars >= 10000) {
                $formattedRevenue = '$' . number_format($dollars / 1000, 1) . 'k';
            } elseif ($dollars >= 1000) {
                $formattedRevenue = '$' . number_format($dollars, 0);
            } else {
                $formattedRevenue = '$' . number_format($dollars, 2);
            }

            $chartData = collect(range(5, 0))->map(function ($monthsAgo) {
                $startOfMonth = now()->subMonthsNoOverflow($monthsAgo)->startOfMonth();
                $endOfMonth = now()->subMonthsNoOverflow($monthsAgo)->endOfMonth();
                
                $amount = \App\Models\Order::where('status', 'paid')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->sum('amount');
                    
                $dollars = $amount / 100;
                
                return [
                    'label' => $startOfMonth->format('M'),
                    'value' => $dollars,
                    'formattedValue' => $dollars >= 1000 ? '$' . number_format($dollars / 1000, 1) . 'k' : '$' . number_format($dollars, 0),
                ];
            });

            $maxChartValue = $chartData->max('value') ?: 1;

            return view('dashboard', [
                'activeMembers' => number_format($activeMembers),
                'memberGrowth' => $memberGrowth > 0 ? '+' . $memberGrowth . '%' : $memberGrowth . '%',
                'memberGrowthClass' => $memberGrowth >= 0 ? 'text-[#4338ca] bg-indigo-50' : 'text-rose-600 bg-rose-50',
                'memberGrowthIcon' => $memberGrowth >= 0 ? 'trending_up' : 'trending_down',
                'newSignups' => number_format($newSignups),
                'formattedRevenue' => $formattedRevenue,
                'revenueGrowth' => $revenueGrowth > 0 ? '+' . $revenueGrowth . '%' : $revenueGrowth . '%',
                'revenueGrowthClass' => $revenueGrowth >= 0 ? 'text-[#4338ca] bg-indigo-50' : 'text-rose-600 bg-rose-50',
                'revenueGrowthIcon' => $revenueGrowth >= 0 ? 'trending_up' : 'trending_down',
                'chartData' => $chartData,
                'maxChartValue' => $maxChartValue,
            ]);
        }
        return redirect()->route('member.dashboard');
    })->name('dashboard');

    // Admin-only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('members', function () {
            $query = \App\Models\User::with('plan')->where('role', \App\Enums\UserRole::Member);

            if ($status = request('status')) {
                if ($status === 'active') $query->whereNotNull('plan_id');
                elseif ($status === 'pending') $query->whereNull('plan_id');
            }

            if ($tier = request('tier')) {
                $query->whereHas('plan', fn ($q) => $q->where('slug', $tier));
            }

            if ($sort = request('sort')) {
                $query->orderBy('updated_at', $sort === 'oldest' ? 'asc' : 'desc');
            } else {
                $query->latest();
            }

            return view('members', ['users' => $query->paginate(10)]);
        })->name('members');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
            Route::post('events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
            Route::put('events/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('events.update');
            Route::delete('events/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');
        });
    });

    // Member dashboard (any authenticated user with member role)
    Route::view('/member/dashboard', 'member_dashboard')->name('member.dashboard');
    Route::view('/member/events', 'member_events')->name('member.events');

    // Team invitation acceptance
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
});

require __DIR__.'/settings.php';
