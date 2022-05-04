<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recall>
 */
class RecallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'mra_public_notice_url' => $this->faker->url,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'user_id' => User::factory(),
            'name' => $this->faker->sentence,
        ];
    }
}
