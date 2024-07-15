<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $products = Product::factory()->count(10)->create();
        $suppliers = Supplier::factory()->count(5)->create();

        foreach ($products as $product) {
            foreach ($suppliers as $supplier) {
                $product->suppliers()->attach($supplier->id, [
                    'value' => rand(100, 1000),
                    'is_winner' => false,
                ]);
            }
        }
    }
}
