<?php

namespace Tests\traits;

use App\Models\Admin;
use App\Models\Profil;
use Database\Factories\ProfilFactory;

trait ProfilCreator
{
    public function createProfil(array $params = []): Profil
    {
        return ProfilFactory::new()
            ->create($params);
    }

    public function createProfilForAdmin(Admin $admin, array $params = []): Profil
    {
        return ProfilFactory::new()
            ->forAdmin($admin)
            ->create($params);
    }
}
