<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sub' => $this->faker->unique()->md5,
            'is_mentor' => $this->faker->randomElement(['t', 'f']),
            'nickname' => $this->faker->sentence(),
            'name' => $this->faker->name,
            'picture' => url('/img/dummyUser.jpeg'),
            'created_at' => $this->faker->dateTime('now', 'ja-JP'),
            'updated_at' => $this->faker->dateTime('now', 'ja-JP'),
        ];
    }
}
                