<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Development>
 */
class DevelopmentFactory extends Factory
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
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'image' => 'developments/' . $this->faker->randomElement($dummyImages),
            'department_id' => Department::inRandomOrder()->first()->id,
        ];
    }
}
