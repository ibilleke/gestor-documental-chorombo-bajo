<?php

namespace App\Models;

use Database\Factories\RolFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Table('roles')]
#[Fillable(['nombre', 'descripcion', 'delicado'])]
class Rol extends Model
{
    /** @use HasFactory<RolFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'delicado' => 'boolean',
        ];
    }

    /**
     * @return BelongsToMany<Permiso, $this>
     */
    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'permiso_rol', 'rol_id', 'permiso_id')
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rol_user', 'rol_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Un rol es delicado si Dirección lo marcó o si tiene al menos un permiso sensible (BRIEF §5).
     */
    public function esDelicado(): bool
    {
        return $this->delicado || $this->permisos->contains('sensible', true);
    }
}
