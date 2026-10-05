<?php

declare(strict_types=1);

namespace Workbench\Database\Seeders;

use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Models\View;
use Illuminate\Database\Seeder;
use Workbench\App\Models\Post;
use Workbench\App\Models\User;

/**
 * Fills the workbench with posts and views spread over the past 90 days, so
 * the columns, filter and widget have numbers to show. A small pool of
 * visitors makes unique counts differ from total counts.
 */
class DatabaseSeeder extends Seeder
{
    private const int Days = 90;

    private const int Visitors = 40;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $visitors = array_map(static fn (): string => fake()->unique()->sha1(), range(1, self::Visitors));

        Post::factory()
            ->count(25)
            ->create()
            ->each(function (Post $post) use ($visitors): void {
                View::factory()
                    ->count(fake()->numberBetween(0, 300))
                    ->for($post, 'viewable')
                    ->state(fn (): array => [
                        'visitor' => fake()->randomElement($visitors),
                        'viewed_at' => Carbon::now()->subMinutes(fake()->numberBetween(0, self::Days * 24 * 60)),
                    ])
                    ->create();
            });
    }
}
