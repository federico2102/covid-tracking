<?php

namespace App\Models;

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

    public function buscarEntrada($user_id)
    {
       return $this->ingresos()
            ->where('user_id', '=', $user_id)
           ->whereNull('salida')
            ->orderBy('id', 'desc')->first();
    }

    public function ingresos()
    {
        return $this->hasMany(Concurrio::class);
    }

    public function ingresarUsuario($user_id)
    {
        $ingreso = $this->ingresos()->create(['user_id'=>$user_id, 'locacion_id'=>$this->id, 'entrada'=>date("Y-m-d h:i:sa")]);

        $user = User::find($user_id);
        $user->locacion = $this->id;
        $user->save();

        $this->Capacidad += 1;
        $this->save();

        return $ingreso;
    }

    public function registrarSalida($user_id)
    {
        $salida = $this->buscarEntrada($user_id);
        $salida->salida = date("Y-m-d h:i:sa");
        $salida->save();

        $user = User::find($user_id);
        $user->locacion = 0;
        $user->save();

        $this->Capacidad -= 1;
        $this->save();

        return $salida;
    }

    public function estuvieronJuntos($user_id, $date)
    {
        $entradas_usuario = $this->ingresos()->where('user_id', '=', $user_id)
        ->where('fecha', '>=', $date);

        $estuvieron = array();
        foreach ($this->ingresos()->where('user_id', '<>', $user_id) as $victima){
            foreach ($entradas_usuario as $usuario){
                if ($victima->entrada >= $usuario->entrada and $victima->entrada <= $usuario->salida){
                    array_push($estuvieron, $victima->user_id);
                } elseif ($victima->salida >= $usuario->entrada and $victima->salida <= $usuario->salida) {
                    array_push($estuvieron, $victima->user_id);
                }
            }
        }
        return array_unique($estuvieron);
    }
}
