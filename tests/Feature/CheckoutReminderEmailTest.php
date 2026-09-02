<?php

use App\Mail\CheckoutReminderMail;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Services\CheckoutPaymentService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

function checkoutReminderPlan(): Plan
{
    return Plan::factory()->create();
}

function abandonedOrder(User $user, Plan $plan, $createdAt = null, array $extra = []): Order
{
    return Order::create(array_merge([
        'user_id' => $user->id,
        'plan_id' => $plan->id,
        'plan_period' => 'one_time',
        'amount' => 9900,
        'status' => 'pending',
        'created_at' => $createdAt ?? now(),
    ], $extra));
}

test('no reminder is sent before the three hour mark', function () {
    Mail::fake();

    $plan = checkoutReminderPlan();
    $user = User::factory()->create();
    abandonedOrder($user, $plan, now()->subHour());

    $this->artisan('checkout:send-reminders')->assertSuccessful();

    Mail::assertNotSent(CheckoutReminderMail::class);
    expect($user->orders()->first()->checkout_reminder_1_sent_at)->toBeNull();
});

test('first reminder is sent three hours after abandonment', function () {
    Mail::fake();

    $plan = checkoutReminderPlan();
    $user = User::factory()->create();
    abandonedOrder($user, $plan, now()->subHours(3)->subMinute());

    $this->artisan('checkout:send-reminders')->assertSuccessful();

    Mail::assertSent(CheckoutReminderMail::class, fn (CheckoutReminderMail $mail) => $mail->hasTo($user->email));

    $order = $user->orders()->first()->fresh();
    expect($order->checkout_reminder_1_sent_at)->not->toBeNull();
    expect($order->checkout_reminder_2_sent_at)->toBeNull();
    expect($order->checkout_reminder_3_sent_at)->toBeNull();
});

test('reminder subjects match the client copy', function () {
    Mail::fake();

    $plan = checkoutReminderPlan();
    $user = User::factory()->create();
    abandonedOrder($user, $plan, now()->subHours(3)->subMinute());

    $this->artisan('checkout:send-reminders');

    Mail::assertSent(CheckoutReminderMail::class, fn (CheckoutReminderMail $mail) => $mail->mailSubject === "You're one step away from joining GMA");
});

test('second reminder is sent forty eight hours after the first', function () {
    Mail::fake();

    $plan = checkoutReminderPlan();
    $user = User::factory()->create();
    abandonedOrder($user, $plan, now()->subHours(51), [
        'checkout_reminder_1_sent_at' => now()->subHours(48)->subMinute(),
    ]);

    $this->artisan('checkout:send-reminders')->assertSuccessful();

    Mail::assertSent(
        CheckoutReminderMail::class,
        fn (CheckoutReminderMail $mail) => $mail->mailSubject === 'Your seat at the table is waiting'
    );

    $order = $user->orders()->first()->fresh();
    expect($order->checkout_reminder_2_sent_at)->not->toBeNull();
    expect($order->checkout_reminder_3_sent_at)->toBeNull();
});

test('third reminder is sent six days after abandonment', function () {
    Mail::fake();

    $plan = checkoutReminderPlan();
    $user = User::factory()->create();
    abandonedOrder($user, $plan, now()->subDays(6)->subMinute(), [
        'checkout_reminder_1_sent_at' => now()->subDays(6)->subMinute(),
        'checkout_reminder_2_sent_at' => now()->subDays(5)->subMinute(),
    ]);

    $this->artisan('checkout:send-reminders')->assertSuccessful();

    Mail::assertSent(
        CheckoutReminderMail::class,
        fn (CheckoutReminderMail $mail) => $mail->mailSubject === "Don't leave your GMA membership unfinished"
    );

    expect($user->orders()->first()->fresh()->checkout_reminder_3_sent_at)->not->toBeNull();
});

test('abandoned orders are skipped when the user paid a later order', function () {
    Mail::fake();

    $plan = checkoutReminderPlan();
    $user = User::factory()->create();
    abandonedOrder($user, $plan, now()->subHours(3)->subMinute());
    abandonedOrder($user, $plan, now()->subHour(), ['status' => 'paid']);

    $this->artisan('checkout:send-reminders')->assertSuccessful();

    Mail::assertNotSent(CheckoutReminderMail::class);
    expect($user->orders()->oldest()->first()->fresh()->checkout_reminder_1_sent_at)->toBeNull();
});

test('abandoned order persists the supplied created_at timestamp', function () {
    $plan = checkoutReminderPlan();
    $user = User::factory()->create();
    $createdAt = now()->subHours(3)->subMinute();
    $order = abandonedOrder($user, $plan, $createdAt);

    expect($order->fresh()->created_at->toDateTimeString())->toBe($createdAt->toDateTimeString());
});

test('resume provides the payment page for the order owner', function () {
    $this->withoutVite();

    $plan = checkoutReminderPlan();
    $user = User::factory()->create();
    $order = abandonedOrder($user, $plan);

    $intent = (object) ['client_secret' => 'pi_test_secret'];

    app()->instance(CheckoutPaymentService::class, new class ($intent)
    {
        public function __construct(public $intent) {}

        public function createForOrder($order)
        {
            return $this->intent;
        }
    });

    $this->actingAs($user)
        ->get(URL::signedRoute('checkout.resume', ['order' => $order->id]))
        ->assertOk()
        ->assertSee('Complete Payment');
});

test('resume rejects orders from other users', function () {
    $this->withoutVite();

    $plan = checkoutReminderPlan();
    $owner = User::factory()->create();
    $other = User::factory()->member()->create(['plan_id' => null]);
    $order = abandonedOrder($owner, $plan);

    $this->actingAs($other)
        ->get(URL::signedRoute('checkout.resume', ['order' => $order->id]))
        ->assertRedirect(route('pricing'));
});

test('resume sends guests to login and returns them after login', function () {
    $this->withoutVite();

    $plan = checkoutReminderPlan();
    $user = User::factory()->create(['password' => bcrypt('password'), 'email_verified_at' => now()]);
    $order = abandonedOrder($user, $plan);

    $signedUrl = URL::signedRoute('checkout.resume', ['order' => $order->id]);

    $this->get($signedUrl)
        ->assertRedirect(route('login'));

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);

    $this->get($signedUrl)->assertOk();
});