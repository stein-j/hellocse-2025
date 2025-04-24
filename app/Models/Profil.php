<?php

namespace App\Models;

use App\ProfilStatus;
use Database\Factories\ProfilFactory;
use Eloquent;
use Faker\Core\Blood;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * 
 *
 * @property int $id
 * @property int $admin_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $image
 * @property ProfilStatus $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Admin $admin
 * @method static \Database\Factories\ProfilFactory factory($count = null, $state = [])
 * @method static Builder<static>|Profil newModelQuery()
 * @method static Builder<static>|Profil newQuery()
 * @method static Builder<static>|Profil query()
 * @method static Builder<static>|Profil whereAdminId($value)
 * @method static Builder<static>|Profil whereCreatedAt($value)
 * @method static Builder<static>|Profil whereFirstName($value)
 * @method static Builder<static>|Profil whereId($value)
 * @method static Builder<static>|Profil whereImage($value)
 * @method static Builder<static>|Profil whereLastName($value)
 * @method static Builder<static>|Profil whereStatus($value)
 * @method static Builder<static>|Profil whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Profil extends Model
{
    /** @use HasFactory<ProfilFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => ProfilStatus::class,
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
