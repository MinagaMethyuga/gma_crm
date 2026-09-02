<?php

namespace App\Console\Commands;

use App\Mail\CheckoutReminderMail;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendCheckoutTestEmails extends Command
{
    protected $signature = 'checkout:test-emails {email}';

    protected $description = 'Send all three example checkout reminder emails to a test address';

    public function handle(): int
    {
        $email = $this->argument('email');

        $user = User::query()->where('email', $email)->first();
        $createdUser = $user === null;

        $user ??= User::factory()->create([
            'email' => $email,
        ]);

        $plan = Plan::query()->where('slug', 'test-plan')->first();
        $createdPlan = $plan === null;

        $plan ??= Plan::factory()->create([
            'slug' => 'test-plan',
        ]);

        $order = Order::query()
            ->where('user_id', $user->id)
            ->where('plan_id', $plan->id)
            ->where('status', 'pending')
            ->first();
        $createdOrder = $order === null;

        $order ??= Order::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'plan_period' => 'one_time',
            'amount' => 9900,
            'status' => 'pending',
            'created_at' => now()->subHours(3)->subMinute(),
        ]);

        try {
            $reminders = [
                ['emails.checkout-reminder-1', "You're one step away from joining GMA"],
                ['emails.checkout-reminder-2', 'Your seat at the table is waiting'],
                ['emails.checkout-reminder-3', "Don't leave your GMA membership unfinished"],
            ];

            foreach ($reminders as [$view, $subject]) {
                $this->info("Sending [{$subject}] to [{$email}]...");
                Mail::to($email)->send(new CheckoutReminderMail($order, $subject, $view));
            }

            $this->info('All three test emails sent. Check the mailbox for delivery.');
        } catch (\Throwable $e) {
            $this->error("Failed to send test emails: {$e->getMessage()}");

            return Command::FAILURE;
        } finally {
            if ($createdOrder) {
                $order->delete();
            }

            if ($createdUser) {
                $user->delete();
            }

            if ($createdPlan) {
                $plan->delete();
            }
        }

        return Command::SUCCESS;
    }
}