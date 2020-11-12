<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nombre',
        'Capacidad',
        'CapacidadMax',
        'Geolocalizacion',
        'QR',
        'Descripcion',
        'Link',
        'Imagen',
        'user_id'
    ];

    public function ingresarUsuario($user_id)
    {
        $this->Capacidad += 1;
        $this->save();

        $user = User::find($user_id);

        $estuvoCon = $this->usuariosEnLocacion();
        foreach ($estuvoCon as $usuario) {
            $usuario->agregarVictima($user);
            $user->agregarVictima($usuario);
        }

        $user->locacion = $this->id;
        $user->save();

        return $this;
    }

    public function tiempoMinimo($desde, $hasta)
    {
        return Carbon::create($desde)->diffInMinutes($hasta) >= 1;
    }

    public function registrarSalida($user_id)
    {
        $user = User::find($user_id);

        $this->Capacidad -= 1;
        $this->save();

        $estuvoCon = $user->victimas()->select(['victima_id', 'entrada'])->get();
        $hasta = Carbon::now();
        foreach ($estuvoCon as $usuario) {
            if (!$this->tiempoMinimo($usuario->entrada, $hasta)) {
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
        return User::all()->where('locacion', '=', $this->id);
    }
}
