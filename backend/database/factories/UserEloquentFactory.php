<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Shared\Infrastructure\Persistence\Eloquent\Models\UserEloquent;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<UserEloquent>
 */
class UserEloquentFactory extends Factory
{
    protected $model = UserEloquent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('secret123')
        ];
    }
}
