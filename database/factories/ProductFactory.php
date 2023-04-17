<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'supplier_id' =>  Supplier::factory(),
            'name' => $this->faker->name(),
            'price' => $this->faker->numberBetween(1500,6000),
            'status' => 1,
            'created_by' => $this->faker->numberBetween(0, 1),
            'category_id' => Category::factory(),
            'unit_id' => Unit::factory(),

        ];
    }
}
