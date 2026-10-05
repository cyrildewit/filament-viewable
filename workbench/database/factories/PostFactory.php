<?php

declare(strict_types=1);

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\Post;

/** @extends Factory<Post> */
class PostFactory extends Factory
{
    /** @var class-string<Post> */
    #[\Override]
    protected $model = Post::class;

    /** @return array<model-property<Post>, mixed> */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraphs(3, true),
        ];
    }
}
