<?php

namespace Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ProfilStatus;
use Tests\TestCase;
use Tests\traits\ProfilCreator;

class ProfilPublicTest extends TestCase
{
    use ProfilCreator;

    public function test_guest_can_retrieve_active_profils(): void
    {
        $this->createProfil(params: ['status' => ProfilStatus::Inactive]);
        $this->createProfil(params: ['status' => ProfilStatus::Pending]);
        $activeProfil1 = $this->createProfil(params: ['status' => ProfilStatus::Active]);
        $activeProfil2 = $this->createProfil(params: ['status' => ProfilStatus::Active]);

        $this
            ->assertGuest()
            ->getJson(route('profils.index'))
            ->assertSuccessful()
            ->assertJsonPath('meta.total', 2)
            ->assertJson([
                'data' => [
                    [
                        'id' => $activeProfil1->id,
                        'first_name' => $activeProfil1->first_name,
                        'last_name' => $activeProfil1->last_name,
                        'image' => null,
                    ],
                    [
                        'id' => $activeProfil2->id,
                        'first_name' => $activeProfil2->first_name,
                        'last_name' => $activeProfil2->last_name,
                        'image' => null,
                    ],
                ],
            ]);
    }

    public function test_admin_can_retrieve_active_profils(): void
    {
        $inactiveProfil = $this->createProfil(params: ['status' => ProfilStatus::Inactive]);
        $pendingProfil = $this->createProfil(params: ['status' => ProfilStatus::Pending]);
        $activeProfil = $this->createProfil(params: ['status' => ProfilStatus::Active]);

        $this
            ->actingAs($this->createAdmin())
            ->getJson(route('profils.index'))
            ->assertSuccessful()
            ->assertJsonPath('meta.total', 3)
            ->assertJson([
                'data' => [
                    [
                        'id' => $inactiveProfil->id,
                        'first_name' => $inactiveProfil->first_name,
                        'last_name' => $inactiveProfil->last_name,
                        'image' => null,
                        'status' => 'inactive',
                    ],
                    [
                        'id' => $pendingProfil->id,
                        'first_name' => $pendingProfil->first_name,
                        'last_name' => $pendingProfil->last_name,
                        'image' => null,
                        'status' => 'pending',
                    ],
                    [
                        'id' => $activeProfil->id,
                        'first_name' => $activeProfil->first_name,
                        'last_name' => $activeProfil->last_name,
                        'image' => null,
                        'status' => 'active',
                    ],
                ],
            ]);
    }
}
