<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Bière (Demi / 25cl)',
                'price' => 400,
                'icon' => 'beer',
            ],
            [
                'name' => 'Bière (Pinte / 50cl)',
                'price' => 650,
                'icon' => 'beer',
            ],
            [
                'name' => 'Jus',
                'price' => 400,
                'icon' => 'drinks-2',
            ],
            [
                'name' => 'Gateau',
                'price' => 300,
                'icon' => 'cake-3',
            ],
            [
                'name' => 'Sandwich',
                'price' => 500,
                'icon' => 'bread',
            ],
        ]);
    }
}
