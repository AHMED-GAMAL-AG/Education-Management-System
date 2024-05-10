<?php

namespace Database\Factories;

use App\Enums\SubjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Subject;
use Database\Seeders\LocalImages;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class SubjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subject::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(),
            'code' => 'SUB-' . Str::random(5),
            'status' => SubjectStatus::getRandomValue(),
            'is_visible' => $this->faker->boolean(),
            'published_at' => $this->faker->date(),
        ];
    }

    public function configure(): SubjectFactory
    {
        return $this->afterCreating(function (Subject $product) {
            try {
                $product
                    ->addMedia(LocalImages::getRandomFile())
                    ->preservingOriginal()
                    ->toMediaCollection('subject-images');
            } catch (UnreachableUrl $exception) {
                return;
            }
        });
    }
}
