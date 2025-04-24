<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilStoreRequest;
use App\Http\Requests\ProfilUpdateRequest;
use App\Http\Resources\ProfilResource;
use App\Models\Admin;
use App\Models\Profil;
use App\ProfilStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProfilController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // TODO: Find a better way to handle middlewares.
            new Middleware('auth:sanctum', only: ['store', 'update', 'destroy']),
            new Middleware('can:update,profil', only: ['update']),
            new Middleware('can:delete,profil', only: ['destroy']),

        ];
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $profils = Profil::query()
            // This is a little brut forced, sorry
            ->when($request->user() === null, fn ($query) => $query->scopes('active'))
            ->paginate();

        return ProfilResource::collection($profils);
    }

    public function store(ProfilStoreRequest $request): JsonResponse
    {
        /** @var Admin $admin */
        $admin = $request->user();

        /** @var Profil $profil */
        $profil = $admin->profils()->make();
        $profil->first_name = $request->get('first_name');
        $profil->last_name = $request->get('last_name');
        $profil->image = $request->file('image')->store('profils');
        $profil->status = $request->enum('status', ProfilStatus::class);
        $profil->save();

        return response()->json([], 201);
    }

    public function update(Profil $profil, ProfilUpdateRequest $request): JsonResponse
    {
        // We can safely retrieve all parameters as they are all validated. Extra parameters are excluded
        $profil->update($request->validated());

        return response()->json();
    }

    public function destroy(Profil $profil): JsonResponse
    {
        // Admin is authenticated and authorized
        $profil->delete();

        return response()->json();
    }
}
