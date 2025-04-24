<?php

namespace App\Http\Controllers;

use App\Exceptions\TooManyCommentsException;
use App\Http\Requests\CommentStoreRequest;
use App\Models\Profil;
use App\Services\CommentPublisher;
use Illuminate\Database\Connection;
use Illuminate\Http\JsonResponse;

class ProfilCommentController extends Controller
{
    public function __construct(
        private readonly CommentPublisher $commentPublisher,
        private readonly Connection $db,
    ) {}

    public function store(Profil $profil, CommentStoreRequest $request): JsonResponse
    {
        try {
            $this->db->transaction(fn () => $this->commentPublisher->publish($request->user(), $profil, $request->get('content')));
        } catch (TooManyCommentsException) {
            return response()->json([
                'code' => 'too_many_comments',
            ], 422);
        }

        return response()->json([], 201);

    }
}
