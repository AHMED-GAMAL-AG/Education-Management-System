<?php

namespace Database\Factories;

use App\Enums\DiplomaStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Diploma;

class DiplomaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Diploma::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => 'DP-' . Str::random(5),
            'description' => $this->faker->sentence(),
            'status' => DiplomaStatus::getRandomValue(),
        ];
    }
}
