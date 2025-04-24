<?php

namespace Tests\traits;

use App\Models\Admin;
use App\Models\Comment;
use App\Models\Profil;
use Database\Factories\CommentFactory;

trait CommentCreator
{
    public function createCommentForAdminAndProfil(Admin $admin, Profil $profil, $params = []): Comment
    {
        return CommentFactory::new()
            ->forAdmin($admin)
            ->forProfil($profil)
            ->create($params);
    }

    public function createCommentForAndProfil(Profil $profil, $params = []): Comment
    {
        return CommentFactory::new()
            ->forProfil($profil)
            ->create($params);
    }
}
