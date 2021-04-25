<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AvailableTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailableTimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AvailableTime::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'availability_id' => 1,
            'time' => $this->faker->randomElement(['15:00', '17:00', '19:00', '21:00', '22:00']),
        ];
    }
}
