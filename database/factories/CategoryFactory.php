<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name= fake()->name();
        return [
            'name'=>$name,
            'slug'=>str()->slug($name),
            'description'=>fake()->text(),
            'image_url'=>fake()->imageUrl(),
        ];
    }
}
