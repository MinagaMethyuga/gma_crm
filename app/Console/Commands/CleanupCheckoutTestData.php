<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Console\Command;

class CleanupCheckoutTestData extends Command
{
    protected $signature = 'checkout:cleanup-test-data';

    protected $description = 'Remove orphaned users, orders, and plans created by earlier failed test runs';

    public function handle(): int
    {
        $emails = [
            'me@globalmobileassociation.biz',
            'anything@example.com',
            'test@example.com',
        ];

        $deletedUsers = 0;
        $deletedOrders = 0;
        $deletedPlans = 0;

        foreach ($emails as $email) {
            $user = User::query()->where('email', $email)->first();

            if ($user === null) {
                continue;
            }

            $orders = Order::query()->where('user_id', $user->id)->get();
            $deletedOrders += $orders->count();

            foreach ($orders as $order) {
                $order->delete();
            }

            $user->delete();
            $deletedUsers += 1;
        }

        foreach (Plan::query()->where('slug', 'test-plan')->get() as $plan) {
            $plan->delete();
            $deletedPlans += 1;
        }

        $this->info("Deleted {$deletedUsers} users, {$deletedOrders} orders, {$deletedPlans} plans.");

        return Command::SUCCESS;
    }
}