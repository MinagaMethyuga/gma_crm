<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\CommunityController;
use App\Http\Controllers\ChatImageController;
use App\Http\Controllers\ChatKeyController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MemberCommunityController;
use App\Http\Controllers\MemberFriendController;
use App\Http\Controllers\MemberNotificationController;
use App\Http\Controllers\StripeWebhookController;
use App\Models\Event;
use App\Models\EventAttendee;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Checkout routes (public endpoints for Stripe redirects)
Route::controller(CheckoutController::class)->group(function () {
    Route::get('/checkout/success', 'success')->name('checkout.success');
    Route::get('/checkout/cancel', 'cancel')->name('checkout.cancel');
});

// Invitations (public/signed)
Route::get('/invitations/{invitation}/accept', [InvitationController::class, 'accept'])
    ->middleware('signed')
    ->name('invitations.accept');

// Stripe webhook (no CSRF, no auth)
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])
    ->withoutMiddleware(VerifyCsrfToken::class)
    ->name('stripe.webhook');

// Public pages
Route::view('/', 'welcome')->name('home');

// Initiate checkout (public — handles auth redirect internally)
Route::get('/checkout/init/{plan}', [CheckoutController::class, 'initCheckout'])->name('checkout.init');

// Resume an abandoned order via signed link (email CTA)
Route::get('/checkout/order/{order}/resume', [CheckoutController::class, 'resume'])
    ->middleware('signed')
    ->name('checkout.resume');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/who-we-serve', fn () => view('who-we-serve'))->name('who-we-serve');
Route::get('/committees', fn () => view('committees'))->name('committees');
Route::get('/research-insights', [DocumentController::class, 'publicIndex'])->name('research-insights');
Route::get('/research-insights/{document}', [DocumentController::class, 'publicShow'])->name('research-insights.show');
Route::get('/research-insights/{document}/stream', [DocumentController::class, 'publicStream'])->name('research-insights.stream');
Route::get('/events', fn () => view('public_events'))->name('events');
Route::get('/admin-events-legacy', fn () => view('events'))->name('events.legacy');
Route::get('/pricing', fn () => view('pricing', ['plans' => Plan::all()->keyBy('slug')]))->name('pricing');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Checkout - create a payment
    Route::post('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');

    // Smart Dashboard Route
    Route::get('dashboard', function () {
        $user = auth()->user();
        if ($user && ! $user->isAdmin()) {
            $hasMembership = $user->plan_id !== null || Order::where('user_id', $user->id)
                ->where('status', 'paid')
                ->exists();
            if (! $hasMembership) {
                return redirect()->route('pricing');
            }
        }

        if (auth()->user()->isAdmin()) {
            $activeMembers = User::where('role', UserRole::Member)->count();
            $lastMonthMembers = User::where('role', UserRole::Member)
                ->where('created_at', '<', now()->startOfMonth())->count();

            $memberGrowth = 0;
            if ($lastMonthMembers > 0) {
                $memberGrowth = round((($activeMembers - $lastMonthMembers) / $lastMonthMembers) * 100);
            } elseif ($activeMembers > 0) {
                $memberGrowth = 100;
            }

            $newSignups = User::where('role', UserRole::Member)
                ->where('created_at', '>=', now()->startOfWeek())->count();

            $totalRevenueCents = Order::where('status', 'paid')->sum('amount');
            $lastMonthCents = Order::where('status', 'paid')
                ->where('created_at', '<', now()->startOfMonth())->sum('amount');

            $revenueGrowth = 0;
            if ($lastMonthCents > 0) {
                $revenueGrowth = round((($totalRevenueCents - $lastMonthCents) / $lastMonthCents) * 100);
            } elseif ($totalRevenueCents > 0) {
                $revenueGrowth = 100;
            }

            $dollars = $totalRevenueCents / 100;
            if ($dollars >= 10000) {
                $formattedRevenue = '$'.number_format($dollars / 1000, 1).'k';
            } elseif ($dollars >= 1000) {
                $formattedRevenue = '$'.number_format($dollars, 0);
            } else {
                $formattedRevenue = '$'.number_format($dollars, 2);
            }

            $chartData = collect(range(5, 0))->map(function ($monthsAgo) {
                $startOfMonth = now()->subMonthsNoOverflow($monthsAgo)->startOfMonth();
                $endOfMonth = now()->subMonthsNoOverflow($monthsAgo)->endOfMonth();

                $amount = Order::where('status', 'paid')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->sum('amount');

                $dollars = $amount / 100;

                return [
                    'label' => $startOfMonth->format('M'),
                    'value' => $dollars,
                    'formattedValue' => $dollars >= 1000 ? '$'.number_format($dollars / 1000, 1).'k' : '$'.number_format($dollars, 0),
                ];
            });

            $maxChartValue = $chartData->max('value') ?: 1;

            $upcomingEvents = Event::withCount(['attendees as registered_count' => fn ($q) => $q->where('status', 'registered')])
                ->where('start_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->take(3)
                ->get();

            $recentActivities = collect();

            User::where('role', UserRole::Member)->latest()->take(3)->get()->each(fn ($u) => $recentActivities->push([
                'icon' => 'person', 'iconBg' => 'bg-cyan-50', 'iconColor' => 'text-cyan-600',
                'message' => "<span class=\"font-bold text-slate-900\">New member joined:</span> {$u->name}",
                'time' => $u->created_at,
            ]));

            Order::with('user')->where('status', 'paid')->latest()->take(3)->get()->each(fn ($o) => $recentActivities->push([
                'icon' => 'attach_money', 'iconBg' => 'bg-indigo-50', 'iconColor' => 'text-[#4338ca]',
                'message' => '<span class="font-bold text-slate-900">Payment received</span> from '.($o->user?->company_name ?: $o->user?->name ?: 'Unknown'),
                'time' => $o->created_at,
            ]));

            Event::latest()->take(3)->get()->each(fn ($e) => $recentActivities->push([
                'icon' => 'campaign', 'iconBg' => 'bg-slate-100', 'iconColor' => 'text-slate-600',
                'message' => "<span class=\"font-bold text-slate-900\">Event created:</span> '{$e->title}'",
                'time' => $e->created_at,
            ]));

            $recentActivities = $recentActivities->sortByDesc('time')->take(3)->values();

            return view('dashboard', [
                'activeMembers' => number_format($activeMembers),
                'memberGrowth' => $memberGrowth > 0 ? '+'.$memberGrowth.'%' : $memberGrowth.'%',
                'memberGrowthClass' => $memberGrowth >= 0 ? 'text-[#4338ca] bg-indigo-50' : 'text-rose-600 bg-rose-50',
                'memberGrowthIcon' => $memberGrowth >= 0 ? 'trending_up' : 'trending_down',
                'newSignups' => number_format($newSignups),
                'formattedRevenue' => $formattedRevenue,
                'revenueGrowth' => $revenueGrowth > 0 ? '+'.$revenueGrowth.'%' : $revenueGrowth.'%',
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
            $query = User::with('plan', 'referrer')
                ->withCount('referrals')
                ->where('role', UserRole::Member);

            if ($status = request('status')) {
                if ($status === 'active') {
                    $query->whereNotNull('plan_id');
                } elseif ($status === 'pending') {
                    $query->whereNull('plan_id');
                }
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
                $downline = User::with('plan')
                    ->where('referred_by', request('downline_id'))
                    ->get();

                return response()->json($downline);
            }

            return view('members', ['users' => $users]);
        })->name('members');

        Route::get('members/{user}/edit', function (User $user) {
            $user->load('plan', 'referrer', 'orders.plan');
            $plans = Plan::orderBy('name')->get();

            $latestOrder = $user->orders()->latest()->first();

            $lastValues = [
                'invoice_number' => null,
                'payment_method' => null,
                'notes' => null,
            ];
            foreach ($user->orders()->whereNotNull('invoice_number')->latest()->get() as $o) {
                if (! $lastValues['invoice_number']) {
                    $lastValues['invoice_number'] = $o->invoice_number;
                }
                if (! $lastValues['payment_method']) {
                    $lastValues['payment_method'] = $o->payment_method;
                }
                if (! $lastValues['notes']) {
                    $lastValues['notes'] = $o->notes;
                }
                if ($lastValues['invoice_number'] && $lastValues['payment_method'] && $lastValues['notes']) {
                    break;
                }
            }

            return response()->json([
                'user' => $user,
                'plans' => $plans,
                'latest_order' => $latestOrder,
                'last_values' => $lastValues,
            ]);
        })->name('members.edit');

        Route::put('members/{user}', function (User $user, Request $request) {
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
                $adminCount = User::where('role', UserRole::Admin)->count();
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
                    $plan = Plan::find($newPlanId);
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
                        if (array_key_exists('invoice_number', $data)) {
                            $orderData['invoice_number'] = $data['invoice_number'];
                        }
                        if (array_key_exists('payment_method', $data)) {
                            $orderData['payment_method'] = $data['payment_method'];
                        }
                        if (array_key_exists('notes', $data)) {
                            $orderData['notes'] = $data['notes'];
                        }
                        if (! empty($orderData)) {
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
                    if (array_key_exists('invoice_number', $data)) {
                        $orderData['invoice_number'] = $data['invoice_number'];
                    }
                    if (array_key_exists('payment_method', $data)) {
                        $orderData['payment_method'] = $data['payment_method'];
                    }
                    if (array_key_exists('notes', $data)) {
                        $orderData['notes'] = $data['notes'];
                    }
                    if (array_key_exists('plan_period', $data)) {
                        $orderData['plan_period'] = $data['plan_period'];
                    }
                    if (! empty($orderData)) {
                        $latestOrder->update($orderData);
                    }
                }
            }

            return response()->json(['success' => true]);
        })->name('members.update');

        Route::put('members/{user}/reset-password', function (User $user, Request $request) {
            $data = $request->validate([
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $user->update(['password' => $data['new_password']]);

            return response()->json(['success' => true, 'message' => 'Password has been reset successfully.']);
        })->name('members.reset-password');

        Route::delete('members/{user}', function (User $user) {
            if ($user->id === auth()->id()) {
                return response()->json(['message' => 'You cannot delete your own account.'], 422);
            }

            $adminCount = User::where('role', UserRole::Admin)->count();
            if ($adminCount <= 1 && $user->isAdmin()) {
                return response()->json(['message' => 'Cannot delete the last admin user.'], 422);
            }

            $user->delete();

            return response()->json(['success' => true, 'message' => 'User has been deleted.']);
        })->name('members.destroy');

        Route::get('members/export', function () {
            $members = User::with('plan', 'referrer')
                ->where('role', UserRole::Member)
                ->latest()
                ->get();

            $filename = 'members_export_'.now()->format('Y-m-d').'.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
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
            Route::get('events', [EventController::class, 'index'])->name('events.index');
            Route::post('events', [EventController::class, 'store'])->name('events.store');
            Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
            Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

            // Documents
            Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
            Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
            Route::put('documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
            Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

            // Community
            Route::get('community', [CommunityController::class, 'index'])->name('community');
            Route::post('community', [CommunityController::class, 'store'])->name('community.store');
            Route::put('community/{communityGroup}', [CommunityController::class, 'update'])->name('community.update');
            Route::delete('community/{communityGroup}', [CommunityController::class, 'destroy'])->name('community.destroy');
            Route::post('community/requests/{joinRequest}/approve', [CommunityController::class, 'approve'])->name('community.requests.approve');
            Route::post('community/requests/{joinRequest}/decline', [CommunityController::class, 'decline'])->name('community.requests.decline');
            Route::post('community/groups/{communityGroup}/approve', [CommunityController::class, 'approveGroup'])->name('community.groups.approve');
            Route::post('community/groups/{communityGroup}/decline', [CommunityController::class, 'declineGroup'])->name('community.groups.decline');
        });
    });

    // Member dashboard (any authenticated user with active subscription)
    Route::middleware(['active_subscription'])->group(function () {
        Route::get('/member/dashboard', function () {
            $upcomingEvents = Event::withCount(['attendees as registered_count' => fn ($q) => $q->where('status', 'registered')])
                ->with(['attendees.user'])
                ->where('start_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->take(2)
                ->get();

            return view('member_dashboard', compact('upcomingEvents'));
        })->name('member.dashboard');
        Route::get('/member/events', function () {
            $gmaEvents = Event::withCount(['attendees as registered_count' => fn ($q) => $q->where('status', 'registered')])
                ->with(['attendees.user'])
                ->where('event_type', 'gma')
                ->latest()
                ->get();

            $otherEvents = Event::withCount(['attendees as registered_count' => fn ($q) => $q->where('status', 'registered')])
                ->with(['attendees.user'])
                ->where('event_type', 'other')
                ->latest()
                ->get();

            $gmaEventsCount = $gmaEvents->count();
            $otherEventsCount = $otherEvents->count();
            $myRegistrationsCount = EventAttendee::where('user_id', auth()->id())->where('status', 'registered')->count();
            $myRegistrations = EventAttendee::with('event')
                ->where('user_id', auth()->id())
                ->where('status', 'registered')
                ->latest()
                ->get();

            $recentRegistrations = EventAttendee::with(['user', 'event'])
                ->where('status', 'registered')
                ->latest()
                ->take(5)
                ->get();

            $upcomingCount = Event::where('start_date', '>=', now())->count();
            $nextEvent = Event::withCount(['attendees as registered_count' => fn ($q) => $q->where('status', 'registered')])
                ->where('start_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->first();

            return view('member_events', compact(
                'gmaEvents', 'otherEvents', 'gmaEventsCount', 'otherEventsCount',
                'myRegistrationsCount', 'myRegistrations', 'recentRegistrations',
                'upcomingCount', 'nextEvent'
            ));
        })->name('member.events');

        Route::post('/member/events/{event}/rsvp', function (Event $event) {
            $userId = auth()->id();

            return DB::transaction(function () use ($event, $userId) {
                // Lock the event row to serialize capacity checks
                $event = Event::where('id', $event->id)->lockForUpdate()->first();

                $attendee = EventAttendee::where('event_id', $event->id)
                    ->where('user_id', $userId)
                    ->first();

                if ($attendee) {
                    $attendee->delete();
                    $status = 'cancelled';
                } else {
                    if ($event->has_seating_capacity && $event->seating_capacity !== null) {
                        $registeredCount = EventAttendee::where('event_id', $event->id)
                            ->where('status', 'registered')
                            ->count();

                        if ($registeredCount >= $event->seating_capacity) {
                            abort(response()->json(['error' => 'Event capacity has been reached.'], 422));
                        }
                    }

                    EventAttendee::create([
                        'event_id' => $event->id,
                        'user_id' => $userId,
                        'status' => 'registered',
                        'registered_at' => now(),
                    ]);
                    $status = 'registered';
                }

                $newCount = EventAttendee::where('event_id', $event->id)
                    ->where('status', 'registered')
                    ->count();

                $attendees = EventAttendee::with('user')
                    ->where('event_id', $event->id)
                    ->where('status', 'registered')
                    ->get()
                    ->map(fn ($a) => [
                        'name' => $a->user->name ?? 'Member',
                        'avatar' => $a->user?->avatarUrl() ?: '',
                    ]);

                return response()->json([
                    'status' => $status,
                    'registered_count' => $newCount,
                    'attendees' => $attendees,
                ]);
            });
        })->name('member.events.rsvp');

        // Member Community
        Route::get('/member/community', [MemberCommunityController::class, 'index'])->name('member.community');
        Route::post('/member/community', [MemberCommunityController::class, 'store'])->name('member.community.store')->middleware('throttle:community-creation');
        Route::post('/member/community/{communityGroup}/join', [MemberCommunityController::class, 'join'])->name('member.community.join');
        Route::post('/member/community/{communityGroup}/request', [MemberCommunityController::class, 'request'])->name('member.community.request');
        Route::post('/member/community/requests/{joinRequest}/cancel', [MemberCommunityController::class, 'cancelRequest'])->name('member.community.request.cancel');
        Route::post('/member/community/{communityGroup}/leave', [MemberCommunityController::class, 'leave'])->name('member.community.leave');
        Route::get('/member/community/{communityGroup}/messages', [MemberCommunityController::class, 'messages'])->name('member.community.messages');
        Route::post('/member/community/{communityGroup}/messages', [MemberCommunityController::class, 'sendMessage'])->name('member.community.messages.send')->middleware('throttle:chat-message');
        Route::post('/member/community/{communityGroup}/messages/bulk-delete', [MemberCommunityController::class, 'deleteMessages'])->name('member.community.messages.delete');
        Route::post('/member/community/{communityGroup}/messages/{message}/pin', [MemberCommunityController::class, 'pinMessage'])->name('member.community.messages.pin');
        Route::post('/member/community/{communityGroup}/messages/{message}/unpin', [MemberCommunityController::class, 'unpinMessage'])->name('member.community.messages.unpin');
        Route::post('/member/community/{communityGroup}/messages/{message}/reaction', [MemberCommunityController::class, 'toggleReaction'])->name('member.community.messages.reaction')->middleware('throttle:chat-action');
        Route::get('/member/community/messages/{message}/image', [ChatImageController::class, 'communityImage'])->name('member.community.messages.image');
        Route::post('/member/community/{communityGroup}/messages/{message}/report', [MemberCommunityController::class, 'reportMessage'])->name('member.community.messages.report')->middleware('throttle:chat-action');
        Route::get('/member/community/{communityGroup}/reports', [MemberCommunityController::class, 'reports'])->name('member.community.reports');
        Route::post('/member/community/{communityGroup}/reports/{report}/remove', [MemberCommunityController::class, 'removeReportedMessage'])->name('member.community.reports.remove');
        Route::post('/member/community/{communityGroup}/reports/{report}/dismiss', [MemberCommunityController::class, 'dismissReport'])->name('member.community.reports.dismiss');
        Route::post('/member/community/{communityGroup}/polls', [MemberCommunityController::class, 'createPoll'])->name('member.community.polls.store')->middleware('throttle:chat-message');
        Route::post('/member/community/{communityGroup}/polls/{poll}/vote', [MemberCommunityController::class, 'votePoll'])->name('member.community.polls.vote')->middleware('throttle:chat-action');
        Route::get('/member/community/{communityGroup}/members', [MemberCommunityController::class, 'members'])->name('member.community.members');
        Route::get('/member/community/{communityGroup}/members/{user}/profile', [MemberCommunityController::class, 'memberProfile'])->name('member.community.members.profile');
        Route::post('/member/community/{communityGroup}/settings', [MemberCommunityController::class, 'updateSettings'])->name('member.community.settings');
        Route::post('/member/community/{communityGroup}/members/{user}/remove', [MemberCommunityController::class, 'removeMember'])->name('member.community.members.remove');
        Route::post('/member/community/{communityGroup}/members/{user}/make-admin', [MemberCommunityController::class, 'makeAdmin'])->name('member.community.members.make-admin');
        Route::post('/member/community/{communityGroup}/members/{user}/revoke-admin', [MemberCommunityController::class, 'revokeAdmin'])->name('member.community.members.revoke-admin');

        // Member Friends
        Route::get('/member/friends/requests', [MemberCommunityController::class, 'friendRequests'])->name('member.friends.requests');
        Route::get('/member/friends/search', [MemberCommunityController::class, 'searchFriends'])->name('member.friends.search');
        Route::post('/member/friends/{user}/request', [MemberCommunityController::class, 'sendFriendRequest'])->name('member.friends.request');
        Route::post('/member/friends/{user}/cancel', [MemberCommunityController::class, 'cancelFriendRequest'])->name('member.friends.cancel');
        Route::post('/member/friends/{user}/accept', [MemberCommunityController::class, 'acceptFriendRequest'])->name('member.friends.accept');
        Route::post('/member/friends/{user}/decline', [MemberCommunityController::class, 'declineFriendRequest'])->name('member.friends.decline');
        Route::get('/member/friends/{user}/messages', [MemberFriendController::class, 'messages'])->name('member.friends.messages');
        Route::post('/member/friends/{user}/messages', [MemberFriendController::class, 'sendMessage'])->name('member.friends.messages.send')->middleware('throttle:chat-message');
        Route::post('/member/friends/{user}/messages/bulk-delete', [MemberFriendController::class, 'deleteMessages'])->name('member.friends.messages.delete');
        Route::post('/member/friends/{user}/messages/{message}/reaction', [MemberFriendController::class, 'toggleReaction'])->name('member.friends.messages.reaction')->middleware('throttle:chat-action');
        Route::get('/member/friends/messages/{message}/image', [ChatImageController::class, 'directImage'])->name('member.friends.messages.image');

        // E2E chat keys. The server only ever stores/relays public key material;
        // the private half stays in the browser.
        Route::get('/member/chat/keys/{user}', [ChatKeyController::class, 'show'])->name('member.chat.keys.show');
        Route::post('/member/chat/keys', [ChatKeyController::class, 'store'])->name('member.chat.keys.store');

        // Member Notifications
        Route::get('/member/notifications', [MemberNotificationController::class, 'index'])->name('member.notifications');
        Route::get('/member/notifications/unread-count', [MemberNotificationController::class, 'unreadCount'])->name('member.notifications.unread-count');
        Route::post('/member/notifications/read-all', [MemberNotificationController::class, 'readAll'])->name('member.notifications.read-all');
        Route::post('/member/notifications/{notification}/read', [MemberNotificationController::class, 'markRead'])->name('member.notifications.read');
        Route::delete('/member/notifications/{notification}', [MemberNotificationController::class, 'destroy'])->name('member.notifications.destroy');

        // Member Documents
        Route::get('/member/documents', [DocumentController::class, 'memberIndex'])->name('member.documents');
        Route::get('/member/documents/{document}', [DocumentController::class, 'show'])->name('member.documents.show');
        Route::get('/member/documents/{document}/stream', [DocumentController::class, 'stream'])->name('member.documents.stream');
    });
});

require __DIR__.'/settings.php';
