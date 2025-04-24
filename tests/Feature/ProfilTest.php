<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Profil;
use App\ProfilStatus;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfilTest extends TestCase
{
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
}
