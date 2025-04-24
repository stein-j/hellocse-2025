<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Profil;
use App\ProfilStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\traits\ProfilCreator;

class ProfilTest extends TestCase
{
    use ProfilCreator;

    public function test_admin_must_be_authenticated(): void
    {
        $this
            ->assertGuest()
            ->postJson(route('profils.store'))
            ->assertUnauthorized();
    }

    public function test_admin_can_create_a_new_profil(): void
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('hello_cse.jpg');
        $admin = $this->createAdmin();

        $this
            ->actingAs($admin)
            ->postJson(route('profils.store'), [
                'first_name' => 'hello',
                'last_name' => 'cse',
                'image' => $file,
                'status' => ProfilStatus::Active,
            ])
            ->assertCreated();

        $profil = Profil::query()->latest()->first();

        $this->assertNotNull($profil);
        $this->assertEquals('hello', $profil->first_name);
        $this->assertEquals('cse', $profil->last_name);
        $this->assertTrue($admin->is($profil->admin));
        $this->assertEquals(ProfilStatus::Active, $profil->status);
        $this->assertStringStartsWith('profils/', $profil->image);
    }

    public function test_admin_cannot_update_a_profil_it_doesnt_own(): void
    {
        $profil = $this->createProfil();

        $this
            ->actingAs($this->createAdmin())
            ->putJson(route('profils.update', $profil))
            ->assertForbidden();

    }

    public function test_admin_can_update_profil(): void
    {
        $admin = $this->createAdmin();
        $profil = $this->createProfilForAdmin($admin, [
            'first_name' => 'hello',
            'last_name' => 'cse',
            'status' => ProfilStatus::Pending,
        ]);

        $this
            ->actingAs($admin)
            ->putJson(route('profils.update', $profil), [
                'first_name' => 'hello_2',
                'last_name' => 'cse_2',
                'status' => ProfilStatus::Active,
            ])
            ->assertSuccessful();

        $profil->refresh();

        $this->assertEquals('hello_2', $profil->first_name);
        $this->assertEquals('cse_2', $profil->last_name);
        $this->assertEquals(ProfilStatus::Active, $profil->status);
    }

    public function test_admin_can_delete_profil(): void
    {
        $admin = $this->createAdmin();
        $profil = $this->createProfilForAdmin($admin);

        $this
            ->actingAs($admin)
            ->deleteJson(route('profils.update', $profil))
            ->assertSuccessful();

        $this->assertDatabaseMissing(Profil::class);
    }
}
