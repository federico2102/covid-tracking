<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nombre', 'Capacidad', 'CapacidadMax', 'Geolocalizacion', 'QR', 'Descripcion', 'Link', 'Imagen', 'user_id'
    ];

    public function ingresarUsuario($user): Locacion
    {
        $this->increment('Capacidad');
        $this->save();

        foreach ($this->usuariosEnLocacion() as $usuario) {
            $usuario->agregarVictima($user);
            $user->agregarVictima($usuario);
        }

        $user->locacion = $this->id;
        $user->save();

        return $this;
    }

    public function registrarSalida($user): Locacion
    {
        $this->decrement('Capacidad');
        $this->save();

        foreach ($user->victimas()->select(['victima_id', 'entrada'])->get() as $usuario) {
            if (!$this->tiempoMinimo($usuario->entrada, Carbon::now())) {
                $user->borrarVictima($usuario);
                $usuario->borrarVictima($user);
            }
        }

        $user->locacion = 0;
        $user->save();

        return $this;
    }

    public function usuariosEnLocacion()
    {
        return User::where('locacion', $this->id)->get();
    }

    private function tiempoMinimo($desde, $hasta): bool
    {
        return Carbon::create($desde)->diffInMinutes($hasta) >= 1;
    }
}
