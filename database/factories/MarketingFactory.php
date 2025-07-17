<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Marketing>
 */
class MarketingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $dummyImages = ['usr1.png', 'usr2.png', 'usr3.png', 'usr5.png', 'usr6.png','usr7.png','usr8.png'];

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'image' => 'marketings/' . $this->faker->randomElement($dummyImages),
        ];
    }
}
