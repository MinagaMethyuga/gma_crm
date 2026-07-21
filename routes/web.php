<?php

use App\Http\Controllers\DocumentController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

// Checkout routes (public endpoints for Stripe redirects)
Route::controller(\App\Http\Controllers\CheckoutController::class)->group(function () {
    Route::get('/checkout/success', 'success')->name('checkout.success');
    Route::get('/checkout/cancel', 'cancel')->name('checkout.cancel');
});

// Invitations (public/signed)
Route::get('/invitations/{invitation}/accept', [\App\Http\Controllers\InvitationController::class, 'accept'])
    ->middleware('signed')
    ->name('invitations.accept');

// Stripe webhook (no CSRF, no auth)
Route::post('/stripe/webhook', [\App\Http\Controllers\StripeWebhookController::class, 'handle'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class)
    ->name('stripe.webhook');

// Public pages
Route::view('/', 'welcome')->name('home');

// Initiate checkout (public — handles auth redirect internally)
Route::get('/checkout/init/{plan}', [\App\Http\Controllers\CheckoutController::class, 'initCheckout'])->name('checkout.init');
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
        $user = auth()->user();
        if ($user && !$user->isAdmin()) {
            $hasMembership = $user->plan_id !== null || \App\Models\Order::where('user_id', $user->id)
                ->where('status', 'paid')
                ->exists();
            if (!$hasMembership) {
                return redirect()->route('pricing');
            }
        }

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

            $upcomingEvents = \App\Models\Event::withCount(['attendees as registered_count' => fn($q) => $q->where('status', 'registered')])
                ->where('start_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->take(3)
                ->get();

            $recentActivities = collect();

            \App\Models\User::where('role', \App\Enums\UserRole::Member)->latest()->take(3)->get()->each(fn($u) => $recentActivities->push([
                'icon' => 'person', 'iconBg' => 'bg-cyan-50', 'iconColor' => 'text-cyan-600',
                'message' => "<span class=\"font-bold text-slate-900\">New member joined:</span> {$u->name}",
                'time' => $u->created_at,
            ]));

            \App\Models\Order::with('user')->where('status', 'paid')->latest()->take(3)->get()->each(fn($o) => $recentActivities->push([
                'icon' => 'attach_money', 'iconBg' => 'bg-indigo-50', 'iconColor' => 'text-[#4338ca]',
                'message' => "<span class=\"font-bold text-slate-900\">Payment received</span> from " . ($o->user?->company_name ?: $o->user?->name ?: 'Unknown'),
                'time' => $o->created_at,
            ]));

            \App\Models\Event::latest()->take(3)->get()->each(fn($e) => $recentActivities->push([
                'icon' => 'campaign', 'iconBg' => 'bg-slate-100', 'iconColor' => 'text-slate-600',
                'message' => "<span class=\"font-bold text-slate-900\">Event created:</span> '{$e->title}'",
                'time' => $e->created_at,
            ]));

            $recentActivities = $recentActivities->sortByDesc('time')->take(3)->values();

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
                'upcomingEvents' => $upcomingEvents,
                'recentActivities' => $recentActivities,
            ]);
        }
        return redirect()->route('member.dashboard');
    })->name('dashboard');

    // Admin-only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('members', function () {
            $query = \App\Models\User::with('plan', 'referrer')
                ->withCount('referrals')
                ->where('role', \App\Enums\UserRole::Member);

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

            $users = $query->paginate(10);

            if (request()->ajax()) {
                $downline = \App\Models\User::with('plan')
                    ->where('referred_by', request('downline_id'))
                    ->get();
                return response()->json($downline);
            }

            return view('members', ['users' => $users]);
        })->name('members');

        Route::get('members/{user}/edit', function (\App\Models\User $user) {
            $user->load('plan', 'referrer', 'orders.plan');
            $plans = \App\Models\Plan::orderBy('name')->get();

            $latestOrder = $user->orders()->latest()->first();

            $lastValues = [
                'invoice_number' => null,
                'payment_method' => null,
                'notes' => null,
            ];
            foreach ($user->orders()->whereNotNull('invoice_number')->latest()->get() as $o) {
                if (!$lastValues['invoice_number']) $lastValues['invoice_number'] = $o->invoice_number;
                if (!$lastValues['payment_method']) $lastValues['payment_method'] = $o->payment_method;
                if (!$lastValues['notes']) $lastValues['notes'] = $o->notes;
                if ($lastValues['invoice_number'] && $lastValues['payment_method'] && $lastValues['notes']) break;
            }

            return response()->json([
                'user' => $user,
                'plans' => $plans,
                'latest_order' => $latestOrder,
                'last_values' => $lastValues,
            ]);
        })->name('members.edit');

        Route::put('members/{user}', function (\App\Models\User $user, \Illuminate\Http\Request $request) {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'company_name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'industry' => 'nullable|string|max:255',
                'job_title' => 'nullable|string|max:255',
                'physical_address' => 'nullable|string|max:500',
                'company_website' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:100',
                'role' => 'required|string|in:admin,member',
                'plan_id' => 'nullable|integer|exists:plans,id',
                'plan_period' => 'nullable|string|in:monthly,yearly',
                'invoice_number' => 'nullable|string|max:255',
                'payment_method' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
            ]);

            if ($data['role'] !== $user->role->value) {
                $adminCount = \App\Models\User::where('role', \App\Enums\UserRole::Admin)->count();
                if ($adminCount <= 1 && $user->isAdmin()) {
                    return response()->json(['message' => 'Cannot change role of the last admin user.'], 422);
                }
                $user->role = $data['role'];
            }

            $rawPlanId = $request->input('plan_id');
            $newPlanId = $rawPlanId !== null && $rawPlanId !== '' ? (int) $rawPlanId : null;
            $oldPlanId = $user->plan_id;

            $planChanged = $newPlanId !== $oldPlanId;

            if ($planChanged) {
                $user->update([
                    'name' => $data['name'],
                    'company_name' => $data['company_name'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'industry' => $data['industry'] ?? null,
                    'job_title' => $data['job_title'] ?? null,
                    'physical_address' => $data['physical_address'] ?? null,
                    'company_website' => $data['company_website'] ?? null,
                    'country' => $data['country'] ?? null,
                    'plan_id' => $newPlanId,
                    'plan_subscribed_at' => $newPlanId ? now() : null,
                ]);

                if ($newPlanId) {
                    $plan = \App\Models\Plan::find($newPlanId);
                    $amount = 0;
                    if ($plan) {
                        $amount = $data['plan_period'] === 'yearly' ? ($plan->yearly_price ?? 0) : ($plan->monthly_price ?? 0);
                    }

                    $order = $user->orders()->create([
                        'plan_id' => $newPlanId,
                        'plan_period' => $data['plan_period'] ?? 'monthly',
                        'amount' => $amount,
                        'status' => 'paid',
                        'invoice_number' => $data['invoice_number'] ?? null,
                        'payment_method' => $data['payment_method'] ?? null,
                        'notes' => $data['notes'] ?? null,
                    ]);
                } else {
                    $latestOrder = $user->orders()->latest()->first();
                    if ($latestOrder) {
                        $orderData = [];
                        if (array_key_exists('invoice_number', $data)) $orderData['invoice_number'] = $data['invoice_number'];
                        if (array_key_exists('payment_method', $data)) $orderData['payment_method'] = $data['payment_method'];
                        if (array_key_exists('notes', $data)) $orderData['notes'] = $data['notes'];
                        if (!empty($orderData)) {
                            $latestOrder->update($orderData);
                        }
                    }
                }
            } else {
                $user->update([
                    'name' => $data['name'],
                    'company_name' => $data['company_name'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'industry' => $data['industry'] ?? null,
                    'job_title' => $data['job_title'] ?? null,
                    'physical_address' => $data['physical_address'] ?? null,
                    'company_website' => $data['company_website'] ?? null,
                    'country' => $data['country'] ?? null,
                ]);

                $latestOrder = $user->orders()->latest()->first();
                if ($latestOrder) {
                    $orderData = [];
                    if (array_key_exists('invoice_number', $data)) $orderData['invoice_number'] = $data['invoice_number'];
                    if (array_key_exists('payment_method', $data)) $orderData['payment_method'] = $data['payment_method'];
                    if (array_key_exists('notes', $data)) $orderData['notes'] = $data['notes'];
                    if (array_key_exists('plan_period', $data)) $orderData['plan_period'] = $data['plan_period'];
                    if (!empty($orderData)) {
                        $latestOrder->update($orderData);
                    }
                }
            }

            return response()->json(['success' => true]);
        })->name('members.update');

        Route::put('members/{user}/reset-password', function (\App\Models\User $user, \Illuminate\Http\Request $request) {
            $data = $request->validate([
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $user->update(['password' => $data['new_password']]);

            return response()->json(['success' => true, 'message' => 'Password has been reset successfully.']);
        })->name('members.reset-password');

        Route::delete('members/{user}', function (\App\Models\User $user) {
            if ($user->id === auth()->id()) {
                return response()->json(['message' => 'You cannot delete your own account.'], 422);
            }

            $adminCount = \App\Models\User::where('role', \App\Enums\UserRole::Admin)->count();
            if ($adminCount <= 1 && $user->isAdmin()) {
                return response()->json(['message' => 'Cannot delete the last admin user.'], 422);
            }

            $user->delete();

            return response()->json(['success' => true, 'message' => 'User has been deleted.']);
        })->name('members.destroy');

        Route::get('members/export', function () {
            $members = \App\Models\User::with('plan', 'referrer')
                ->where('role', \App\Enums\UserRole::Member)
                ->latest()
                ->get();

            $filename = 'members_export_' . now()->format('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($members) {
                $handle = fopen('php://output', 'w');
                fwrite($handle, "\xEF\xBB\xBF");
                fputcsv($handle, ['Name', 'Email', 'Company', 'Industry', 'Job Title', 'Phone', 'Country', 'Tier', 'Status', 'Subscribed At', 'Joined At', 'Referred By', 'Referral Code']);

                foreach ($members as $user) {
                    fputcsv($handle, [
                        $user->name,
                        $user->email,
                        $user->company_name ?? '',
                        $user->industry ?? '',
                        $user->job_title ?? '',
                        $user->phone ?? '',
                        $user->country ?? '',
                        $user->plan?->name ?? 'No Plan',
                        $user->plan_id ? 'Active' : 'Pending',
                        $user->plan_subscribed_at?->format('Y-m-d') ?? '',
                        $user->created_at->format('Y-m-d'),
                        $user->referrer?->name ?? '',
                        $user->referral_code ?? '',
                    ]);
                }

                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        })->name('members.export');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
            Route::post('events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
            Route::put('events/{event}', [\App\Http\Controllers\EventController::class, 'update'])->name('events.update');
            Route::delete('events/{event}', [\App\Http\Controllers\EventController::class, 'destroy'])->name('events.destroy');

            // Documents
            Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
            Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
            Route::put('documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
            Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        });
    });

    // Member dashboard (any authenticated user with active subscription)
    Route::middleware(['active_subscription'])->group(function () {
        Route::get('/member/dashboard', function () {
            $upcomingEvents = \App\Models\Event::withCount(['attendees as registered_count' => fn($q) => $q->where('status', 'registered')])
                ->with(['attendees.user'])
                ->where('start_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->take(2)
                ->get();
            return view('member_dashboard', compact('upcomingEvents'));
        })->name('member.dashboard');
        Route::get('/member/events', function () {
            $gmaEvents = \App\Models\Event::withCount(['attendees as registered_count' => fn($q) => $q->where('status', 'registered')])
                ->with(['attendees.user'])
                ->where('event_type', 'gma')
                ->latest()
                ->get();

            $otherEvents = \App\Models\Event::withCount(['attendees as registered_count' => fn($q) => $q->where('status', 'registered')])
                ->with(['attendees.user'])
                ->where('event_type', 'other')
                ->latest()
                ->get();

            $gmaEventsCount = $gmaEvents->count();
            $otherEventsCount = $otherEvents->count();
            $myRegistrationsCount = \App\Models\EventAttendee::where('user_id', auth()->id())->where('status', 'registered')->count();
            $myRegistrations = \App\Models\EventAttendee::with('event')
                ->where('user_id', auth()->id())
                ->where('status', 'registered')
                ->latest()
                ->get();

            $recentRegistrations = \App\Models\EventAttendee::with(['user', 'event'])
                ->where('status', 'registered')
                ->latest()
                ->take(5)
                ->get();

            $upcomingCount = \App\Models\Event::where('start_date', '>=', now())->count();
            $nextEvent = \App\Models\Event::withCount(['attendees as registered_count' => fn($q) => $q->where('status', 'registered')])
                ->where('start_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->first();

            return view('member_events', compact(
                'gmaEvents', 'otherEvents', 'gmaEventsCount', 'otherEventsCount',
                'myRegistrationsCount', 'myRegistrations', 'recentRegistrations',
                'upcomingCount', 'nextEvent'
            ));
        })->name('member.events');

        Route::post('/member/events/{event}/rsvp', function (\App\Models\Event $event) {
            $userId = auth()->id();
            
            $attendee = \App\Models\EventAttendee::where('event_id', $event->id)
                ->where('user_id', $userId)
                ->first();
                
            if ($attendee) {
                $attendee->delete();
                $status = 'cancelled';
            } else {
                $registeredCount = \App\Models\EventAttendee::where('event_id', $event->id)
                    ->where('status', 'registered')
                    ->count();
                if ($event->has_seating_capacity && $event->seating_capacity && $registeredCount >= $event->seating_capacity) {
                    return response()->json(['error' => 'Event capacity has been reached.'], 422);
                }

                \App\Models\EventAttendee::create([
                    'event_id' => $event->id,
                    'user_id' => $userId,
                    'status' => 'registered',
                    'registered_at' => now(),
                ]);
                $status = 'registered';
            }
            
            $newCount = \App\Models\EventAttendee::where('event_id', $event->id)
                ->where('status', 'registered')
                ->count();

            $attendees = \App\Models\EventAttendee::with('user')
                ->where('event_id', $event->id)
                ->where('status', 'registered')
                ->get()
                ->map(fn($a) => [
                    'name' => $a->user->name ?? 'Member',
                    'avatar' => $a->user ? $a->user->avatarUrl() : '',
                ]);

            return response()->json([
                'status' => $status,
                'registered_count' => $newCount,
                'attendees' => $attendees,
            ]);
        })->name('member.events.rsvp');


        // Member Documents
        Route::get('/member/documents', [DocumentController::class, 'memberIndex'])->name('member.documents');
        Route::get('/member/documents/{document}', [DocumentController::class, 'show'])->name('member.documents.show');
        Route::get('/member/documents/{document}/stream', [DocumentController::class, 'stream'])->name('member.documents.stream');
    });
});

require __DIR__.'/settings.php';
