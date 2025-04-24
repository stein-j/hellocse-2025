<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilStoreRequest;
use App\Models\Admin;
use App\Models\Profil;
use App\ProfilStatus;

class ProfilController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfilStoreRequest $request)
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
}
