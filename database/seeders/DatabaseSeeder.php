<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Diploma;
use App\Models\StudyPlan;
use App\Models\Subject;
use App\Models\User;
use Closure;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear images
        Storage::deleteDirectory('public');

        // // Tutor and student roles
        // $this->command->warn(PHP_EOL . 'Creating Tutor and student roles...');
        // $this->call(RoleSeeder::class);
        // $this->command->info('Tutor and student roles Created.');

        // // Tutor and student users
        // $this->command->warn(PHP_EOL . 'Creating Tutors and students...');
        // $customers = $this->withProgressBar(100, fn () => User::factory()->count(1)->create());
        // $this->command->info('Tutors and students Created.');

        // Create Categories With multiple levels
        $this->command->warn(PHP_EOL . 'Creating Categories...');
        $categories = $this
            ->withProgressBar(
                50,
                fn () => Category::factory(1)
                    ->has(Category::factory()->count(3), 'children')
                    ->create()
            );
        $this->command->info('Categories Created.');

        // Subjects
        $this->command->warn(PHP_EOL . 'Creating Subjects...');
        $subjects = $this
            ->withProgressBar(
                100,
                fn () => Subject::factory(1)
                    ->hasAttached($categories->random(rand(3, 6)))
                    ->create()
            );
        $this->command->info('Subjects Created.');

        // Courses
        $this->command->warn(PHP_EOL . 'Creating Courses...');
        $courses = $this->withProgressBar(
            100,
            fn () => Course::factory(1)
                ->for($subjects->random())
                ->create()
        );

        // Diploma
        $this->command->warn(PHP_EOL . 'Creating Diplomas...');
        $diplomas = $this->withProgressBar(
            100,
            fn () => Diploma::factory(1)
                ->hasAttached($subjects->random(rand(3, 6)), ['price' => rand(100, 1000)])
                ->create()
        );

        // Study Plans
        $this->command->warn(PHP_EOL . 'Creating Study Plans...');
        $this->withProgressBar(
            100,
            fn () => StudyPlan::factory(1)
                ->hasAttached($diplomas->random())
                ->hasAttached($courses->random())
                ->create()
        );
    }

    protected function withProgressBar(int $amount, Closure $createCollectionOfOne): Collection
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $amount);

        $progressBar->start();

        $items = new Collection();

        foreach (range(1, $amount) as $i) {
            $items = $items->merge(
                $createCollectionOfOne()
            );
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');

        return $items;
    }
}
