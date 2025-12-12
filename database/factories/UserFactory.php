<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usr_name' => fake()->name(),
            'password' => static::$password ??= Hash::make('password'),
            'registered_as' => fake()->randomElement(['Organizer', 'Volunteer']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user is an organizer.
     */
    public function organizer(): static
    {
        return $this->state(fn (array $attributes) => [
            'registered_as' => 'Organizer',
        ]);
    }

    /**
     * Indicate that the user is a volunteer.
     */
    public function volunteer(): static
    {
        return $this->state(fn (array $attributes) => [
            'registered_as' => 'Volunteer',
        ]);
    }
}
