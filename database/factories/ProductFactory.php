<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $products = [
            ['Beras Ramos 5 Kg', 'Sembako', 65000, 72000],
            ['Minyak Goreng 1 L', 'Sembako', 18000, 22000],
            ['Gula Pasir 1 Kg', 'Sembako', 14500, 17000],
            ['Tepung Terigu', 'Sembako', 10000, 12000],
            ['Mie Instan', 'Makanan', 2800, 3500],
            ['Kopi Kapal Api', 'Minuman', 1800, 2500],
            ['Teh Celup', 'Minuman', 7000, 9000],
            ['Sabun Lifebuoy', 'Sabun', 3500, 5000],
            ['Shampo Sunsilk', 'Sabun', 12000, 15000],
            ['Susu Kental Manis', 'Minuman', 9000, 11000],
            ['Biskuit Roma', 'Camilan', 7000, 9000],
            ['Wafer Tango', 'Camilan', 8000, 10000],
            ['Air Mineral', 'Minuman', 2500, 4000],
            ['Kecap Manis', 'Sembako', 12000, 15000],
            ['Garam Dapur', 'Sembako', 2500, 4000],
        ];

        $item = fake()->randomElement($products);

        return [
            'name' => $item[0],
            'category' => $item[1],
            'price_buy' => $item[2],
            'price_sell' => $item[3],
            'stock' => fake()->numberBetween(5, 50),
        ];
    }
}