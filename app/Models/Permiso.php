<?php

namespace App\Models;

use Database\Factories\PermisoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Table('permisos')]
#[Fillable(['nombre', 'descripcion', 'sensible'])]
class Permiso extends Model
{
    /** @use HasFactory<PermisoFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'sensible' => 'boolean',
        ];
    }

    /**
     * @return BelongsToMany<Rol, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'permiso_rol', 'permiso_id', 'rol_id')
            ->withTimestamps();
    }
}
