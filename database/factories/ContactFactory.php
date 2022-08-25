<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'      => fake()->firstName(),
            'last_name'       => fake()->lastName(),
            'legal_name'      => null,
            'is_legal_entity' => 0,
            'gender'          => fake()->randomElement(['male', 'female', 'trans', 'other']),
            'email'           => fake()->safeEmail(),
            'street'          => fake()->streetName(),
            'building'        => fake('en_US')->streetSuffix(),
            'number'          => fake()->numberBetween(1, 500),
            'postal_code'     => fake()->postcode(),
            'city'            => fake()->city(),
            'country'         => fake()->country(),
            'home_number'     => fake()->boolean() ? null : fake()->phoneNumber(),
            'mobile_number'   => fake()->boolean() ? null : fake()->phoneNumber(),
            'work_number'     => fake()->boolean() ? null : fake()->phoneNumber(),
            'comments'        => fake()->realText(10000),
            'is_client'       => fake()->boolean(80),
            'is_user'         => 0,
            'department_id'   => null,
        ];
    }

    public function legal(): ContactFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name'      => null,
                'last_name'       => null,
                'legal_name'      => fake()->company(),
                'is_legal_entity' => 1,
                'gender'          => null,
                'home_number'     => null,
                'mobile_number'   => null,
                'is_user'         => 0,
            ];
        });
    }
}
