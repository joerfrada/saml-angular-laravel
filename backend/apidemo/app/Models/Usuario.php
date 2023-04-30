<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'tb_sg_usuarios';

    protected $primaryKey = 'usuario_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario',
        'nombre_completo',
        'email',
        'activo',
        'usuario_creador',
        'fecha_creacion',
        'usuario_modificador',
        'fecha_modificacion'
    ];
}
