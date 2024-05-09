<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Subject;
use Database\Seeders\LocalImages;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnreachableUrl;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => 'CR-' . Str::random(5),
            'duration' => $this->faker->time(),
        ];
    }

    public function configure(): CourseFactory
    {
        return $this->afterCreating(function (Course $product) {
            try {
                $product
                    ->addMedia(LocalImages::getRandomFile())
                    ->preservingOriginal()
                    ->toMediaCollection('course-images');
            } catch (UnreachableUrl $exception) {
                return;
            }
        });
    }
}
