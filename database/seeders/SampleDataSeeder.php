<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing customers
        $customers = User::role('customer')->get();
        
        if ($customers->isEmpty()) {
            $this->command->info('No customers found. Creating sample customer...');
            $customer = User::create([
                'name' => 'Sample Customer',
                'email' => 'sample@customer.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $customer->assignRole('customer');
            $customers = collect([$customer]);
        }

        // Create sample orders for each customer
        foreach ($customers as $customer) {
            // Create 2-5 orders per customer
            $orderCount = rand(2, 5);
            
            for ($i = 1; $i <= $orderCount; $i++) {
                $order = Order::create([
                    'user_id' => $customer->id,
                    'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                    'status' => $this->getRandomStatus(),
                    'payment_status' => $this->getRandomPaymentStatus(),
                    'subtotal' => rand(1000, 50000) / 100,
                    'tax_total' => rand(100, 2000) / 100,
                    'shipping_total' => rand(0, 500) / 100,
                    'discount_total' => rand(0, 1000) / 100,
                    'grand_total' => rand(1500, 60000) / 100,
                    'currency' => 'INR',
                    'placed_at' => now()->subDays(rand(1, 30)),
                ]);

                // Create 1-3 reviews per customer
                $reviewCount = rand(1, 3);
                for ($j = 1; $j <= $reviewCount; $j++) {
                    Review::create([
                        'user_id' => $customer->id,
                        'order_id' => $order->id,
                        'title' => 'Great product!',
                        'comment' => 'This is a sample review comment for testing purposes.',
                        'rating' => rand(3, 5),
                        'status' => $this->getRandomReviewStatus(),
                        'is_verified_purchase' => true,
                    ]);
                }
            }
        }

        $this->command->info('Sample orders and reviews created successfully!');
    }

    private function getRandomStatus(): string
    {
        $statuses = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'];
        return $statuses[array_rand($statuses)];
    }

    private function getRandomPaymentStatus(): string
    {
        $statuses = ['pending', 'paid', 'failed', 'refunded'];
        return $statuses[array_rand($statuses)];
    }

    private function getRandomReviewStatus(): string
    {
        $statuses = ['pending', 'approved', 'rejected'];
        return $statuses[array_rand($statuses)];
    }
}
