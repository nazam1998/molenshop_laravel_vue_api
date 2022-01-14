<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shop;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $shop = Shop::inRandomOrder()->withCount('products')->get();
        $shop = $shop->where('products_count', '<', 10)->first();
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->realText(),
            'cover_path' => 'mockup.jpg',
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 5000),
            'stock' => $this->faker->randomDigitNotNull(),
            'shop_id' => $shop->id
        ];
    }
}
