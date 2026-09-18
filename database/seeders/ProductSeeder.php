<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Product::create([
      'name' => 'Pizza',
      'description' => 'Cheese pizza',
      'price' => 12.99,
      'quantity' => 10,
    ]);

    Product::create([
      'name' => 'Pasta',
      'description' => 'Pasta description',
      'price' => 8.99,
      'quantity' => 10,
    ]);

    Product::create([
      'name' => 'Water',
      'description' => 'Plain water',
      'price' => 1.99,
      'quantity' => 10,
    ]);

    Product::create([
      'name' => 'Milk',
      'description' => 'Regular cow milk',
      'price' => 3.99,
      'quantity' => 10,
    ]);
  }
}
