<?php

namespace App\Services;

use App\Exceptions\TooManyCommentsException;
use App\Models\Admin;
use App\Models\Comment;
use App\Models\Profil;

class CommentPublisher
{
    /**
     * @throws TooManyCommentsException
     */
    public function publish(Admin $admin, Profil $profil, string $content): Comment
    {
        if ($profil->comments()->where('admin_id', $admin->id)->exists()) {
            throw new TooManyCommentsException;
        }

        /** @var Comment $comment */
        $comment = $profil->comments()->make();
        $comment->admin()->associate($admin);
        $comment->content = $content;
        $comment->save();

        return $comment;
    }
}
