<?php

namespace Database\Factories;

use App\Models\Admin;
use App\ProfilStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profil>
 */
class ProfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'admin_id' => fn () => AdminFactory::new(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'image' => null,
            'status' => ProfilStatus::Active,
        ];
    }

    public function forAdmin(Admin $admin): self
    {
        return $this->state(fn () => [
            'admin_id' => $admin->getKey(),
        ]);
    }
}
