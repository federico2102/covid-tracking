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
        'Imagen',
        'Creador'
    ];

    public function ingresarUsuario($user_id)
    {
        $ingreso = $this->ingresos()->create(['user_id' => $user_id, 'locacion_id' => $this->id, 'entrada' => date("Y-m-d h:i:sa")]);

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

        return $ingreso;
    }

    public function x_seconds($to_check1, $to_check2)
    {
        return Carbon::create($to_check1)->diffInMinutes($to_check2) > 30;
    }

    public function registrarSalida($user_id)
    {
        $salida = $this->buscarEntrada($user_id);
        $salida->salida = Carbon::now();
        $salida->save();

        $user = User::find($user_id);

        $this->Capacidad -= 1;
        $this->save();

        $estuvoCon = $user->victimas()->select(['victima_id', 'entrada'])->get();
        $hasta = Carbon::now();
        foreach ($estuvoCon as $usuario) {
            if (!$this->x_seconds($usuario->entrada, $hasta)) {
                $user->borrarVictima($usuario);
                $usuario->borrarVictima($user);
            }
        }

        $user->locacion = 0;
        $user->save();

        return $salida;
    }

    public function buscarEntrada($user_id)
    {
        return $this->ingresos()
            ->where('user_id', '=', $user_id)
            ->whereNull('salida')
            ->orderBy('id', 'desc')->first();
    }

    public function usuariosEnLocacion()
    {
        return User::all()->where('locacion', '=', $this->id);
    }

    public function ingresos()
    {
        return $this->hasMany(Concurrio::class);
    }
}
