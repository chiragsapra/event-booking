<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+1 week');
        $end = (clone $start)->modify('+2 hours');

        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'country' => $this->faker->country,
            'start_time' => $start,
            'end_time' => $end,
            'capacity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
