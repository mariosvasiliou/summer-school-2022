<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'        => fake()->bothify('Report ???######'),
            'description' => fake()->realText(1000),
            'class_name'  => 'App\\Reports\\NotExistingClass',
            'is_active'   => fake()->boolean(80),
        ];
    }
}
