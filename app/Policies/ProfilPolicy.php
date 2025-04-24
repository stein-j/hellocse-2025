<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Profil;

class ProfilPolicy
{
    public function update(Admin $admin, Profil $profil): bool
    {
        return $admin->is($profil->admin);
    }

    public function delete(Admin $admin, Profil $profil): bool
    {
        return $admin->is($profil->admin);
    }
}
