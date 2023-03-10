<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
         ]);

         $products = Product::factory(1000)->create();

         Order::factory(1000)
             ->create()
             ->each(function ($order)use ($products){
             $order->products()->attach($products->random(rand(1, 3)),[
                    'count' => rand(1, 3),
                    'sum' => rand(1000, 3000),
             ]);
         });
    }


}
