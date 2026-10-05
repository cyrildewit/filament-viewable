<?php

declare(strict_types=1);

namespace Workbench\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Workbench\App\Models\User;

/** @extends Factory<User> */
class UserFactory extends Factory
{
    /** @var class-string<User> */
    #[\Override]
    protected $model = User::class;

    /** @return array<model-property<User>, mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
        ];
    }
}
