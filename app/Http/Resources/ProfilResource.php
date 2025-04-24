<?php

namespace App\Http\Resources;

use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfilResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Profil $profil */
        $profil = $this->resource;

        return [
            'id' => $profil->id,
            'first_name' => $profil->first_name,
            'last_name' => $profil->last_name,
            'image' => $profil->image,
            $this->merge($this->attributsAllowedByAdmin($request, $profil)),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function attributsAllowedByAdmin(Request $request, Profil $profil): array
    {
        // JsonResource cannot really retrieve 'extra' info from the controller
        // so we determine if the admin is authenticated here again.
        if ($request->user() === null) {
            return [];
        }

        return [
            'status' => $profil->status,
        ];

    }
}
