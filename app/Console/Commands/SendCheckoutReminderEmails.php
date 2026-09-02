<?php

namespace App\Console\Commands;

use App\Mail\CheckoutReminderMail;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendCheckoutReminderEmails extends Command
{
    protected $signature = 'checkout:send-reminders';

    protected $description = 'Send abandoned checkout reminder emails (3h, 48h later, 6 days)';

    public function handle(): int
    {
        $orders = Order::query()
            ->where('status', 'pending')
            ->whereNotNull('user_id')
            ->with(['user', 'plan'])
            ->get();

        foreach ($orders as $order) {
            if ($this->userHasPaidLater($order)) {
                continue;
            }

            if ($order->checkout_reminder_1_sent_at === null) {
                if ($order->created_at->lte(now()->subHours(3))) {
                    $this->send($order, 'emails.checkout-reminder-1', "You're one step away from joining GMA");
                    $order->update(['checkout_reminder_1_sent_at' => now()]);
                }
            } elseif ($order->checkout_reminder_2_sent_at === null) {
                if ($order->checkout_reminder_1_sent_at->lte(now()->subHours(48))) {
                    $this->send($order, 'emails.checkout-reminder-2', 'Your seat at the table is waiting');
                    $order->update(['checkout_reminder_2_sent_at' => now()]);
                }
            } elseif ($order->checkout_reminder_3_sent_at === null) {
                if ($order->created_at->lte(now()->subDays(6))) {
                    $this->send($order, 'emails.checkout-reminder-3', "Don't leave your GMA membership unfinished");
                    $order->update(['checkout_reminder_3_sent_at' => now()]);
                }
            }
        }

        return self::SUCCESS;
    }

    private function send(Order $order, string $view, string $subject): void
    {
        if (! $order->user?->email) {
            return;
        }

        Mail::to($order->user->email)
            ->send(new CheckoutReminderMail($order, $subject, $view));
    }

    private function userHasPaidLater(Order $order): bool
    {
        return $order->user?->plan_id !== null
            || Order::query()
                ->where('user_id', $order->user_id)
                ->where('status', 'paid')
                ->where('id', '>', $order->id)
                ->exists();
    }
}