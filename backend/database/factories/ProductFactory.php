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
        $shopName = ['Barbecue Style', 'Dippers Guacamole', 'Dippers Naturel', 'Flamin Hot', 'Nacho Cheese', 'Pure Paprika', 'Sweet Chilli Pepper'];
        $shopImg = ['barbecue_style.jpg', 'dippers_guacamole.jpg', 'dippers_naturel.jpg', 'flamin_hot.jpg', 'nacho_cheese.jpg', 'pure_paprika.jpg', 'sweet_chilli_pepper.jpg'];
        $index = array_rand($shopName);
        return [
            'name' => $shopName[$index],
            'description' => $this->faker->realText(),
            'cover_path' => $shopImg[$index],
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 50),
            'stock' => $this->faker->randomDigitNotNull(),
            'shop_id' => $shop->id
        ];
    }
}
