<?php

namespace Database\Factories\V1;

use App\Models\User;
use App\ticketenum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'title' => fake()->title,
            'discription' =>fake()->paragraph(),
            'status' =>fake()->randomElement([ticketenum::ACTIVE,ticketenum::CANCEL,ticketenum::COMPLETE,ticketenum::HOLDING]),
            'user_id' => User::factory(),
        ];
    }
}
