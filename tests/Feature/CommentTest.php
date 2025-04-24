<?php

namespace Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Comment;
use Tests\TestCase;
use Tests\traits\CommentCreator;
use Tests\traits\ProfilCreator;

class CommentTest extends TestCase
{
    use CommentCreator;
    use ProfilCreator;

    public function test_admin_must_be_authenticated_to_publish_a_comment(): void
    {
        $this
            ->assertGuest()
            ->postJson(route('profils.comments.store', $this->createProfil()))
            ->assertUnauthorized();
    }

    public function test_unknown_profil_return_404(): void
    {
        $this
            ->actingAs($this->createAdmin())
            ->postJson(route('profils.comments.store', 'not_found'))
            ->assertNotFound();

    }

    public function test_admin_can_publish_a_comment(): void
    {
        $admin = $this->createAdmin();
        $profil = $this->createProfil();

        // Let's already add a comment from another admin
        $this->createCommentForAndProfil($profil);

        $this
            ->actingAs($admin)
            ->postJson(route('profils.comments.store', $profil), [
                'content' => 'Hello World.. I mean CSE !',
            ])
            ->assertCreated();

        $this->assertEquals(2, $profil->comments->count());
        /** @var Comment $comment */
        $comment = $profil->comments->last();
        $this->assertEquals('Hello World.. I mean CSE !', $comment->content);
        $this->assertTrue($admin->is($comment->admin));
        $this->assertTrue($profil->is($comment->profil));
    }

    public function test_admin_can_publish_only_once_comment_per_profil(): void
    {
        $admin = $this->createAdmin();
        $profil = $this->createProfilForAdmin($admin);
        $comment = $this->createCommentForAdminAndProfil($admin, $profil);

        $this
            ->actingAs($admin)
            ->postJson(route('profils.comments.store', $profil), [
                'content' => 'second comment',
            ])
            ->assertUnprocessable()
            ->assertJsonPath('code', 'too_many_comments');
    }
}
