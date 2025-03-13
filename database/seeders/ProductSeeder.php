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
                'name' => 'Thé/Café',
                'price' => 50,
                'icon' => 'tea',
                'category' => 'Boissons',
            ],
            [
                'name' => 'Soda',
                'price' => 150,
                'icon' => 'soda',
                'category' => 'Boissons',
            ],
            [
                'name' => 'Barre de céréales',
                'price' => 100,
                'icon' => 'bar',
                'category' => 'Sucrée',
            ],
            [
                'name' => 'Bonbons',
                'price' => 100,
                'icon' => 'candy',
                'category' => 'Sucrée',
            ],
            [
                'name' => 'Sirop à l\'eau',
                'price' => 50,
                'icon' => 'syrup',
                'category' => 'Boissons',
            ],
            [
                'name' => 'Crêpes',
                'price' => 100,
                'icon' => 'pancake',
                'category' => 'Sucrée',
            ],
            [
                'name' => 'Gâteaux maison',
                'price' => 150,
                'icon' => 'cake',
                'category' => 'Sucrée',
            ],
            [
                'name' => 'Snacks salés (quiche, cake)',
                'price' => 150,
                'icon' => 'snack',
                'category' => 'Salé',
            ],
            [
                'name' => 'Chips',
                'price' => 100,
                'icon' => 'chips',
                'category' => 'Salé',
            ],
            [
                'name' => 'Bière (25cl)',
                'price' => 300,
                'icon' => 'beer',
                'category' => 'Boissons',
            ],
        ]);
    }
}
