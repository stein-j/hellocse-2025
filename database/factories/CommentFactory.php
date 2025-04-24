<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Profil;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'profil_id' => fn () => ProfilFactory::new(),
            'content' => fn () => $this->faker->text(),
        ];
    }

    public function forAdmin(Admin $admin): self
    {
        return $this->state(fn () => [
            'admin_id' => $admin->getKey(),
        ]);
    }

    public function forProfil(Profil $profil): self
    {
        return $this->state(fn () => [
            'profil_id' => $profil->getKey(),
        ]);
    }
}
