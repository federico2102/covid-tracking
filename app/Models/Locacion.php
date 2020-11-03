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

    public function ingresarUsuario($user_id)
    {
        $ingreso = $this->ingresos()->create(['user_id'=>$user_id, 'locacion_id'=>$this->id, 'entrada'=>date("Y-m-d h:i:sa")]);

        $this->Capacidad += 1;
        $this->save();

        $user = User::find($user_id);

        $estuvoCon = $this->usuariosEnLocacion();
        foreach ($estuvoCon as $usuario){
            $this->estuvoCon()->create(['user_id'=>$usuario->id, 'locacion_id'=>$this->id, 'desde'=> date("Y-m-d h:i:sa")]);
        }

        $user->locacion = $this->id;
        $user->save();

        return $ingreso;
    }

    public function x_seconds($to_check1 = 'YYYY-mm-dd H:i:s', $to_check2 = 'YYYY-mm-dd H:i:s') {
        return ($to_check2 - $to_check1 > 30 * 60) ? true : false;
    }

    public function registrarSalida($user_id)
    {
        $salida = $this->buscarEntrada($user_id);
        $salida->salida = date("Y-m-d h:i:sa");
        $salida->save();

        $user = User::find($user_id);

        $this->Capacidad -= 1;
        $this->save();

        $estuvoCon = $this->usuariosEnLocacion()->where('id', '<>', $user_id);

        foreach ($estuvoCon as $usuario) {
            $tiempoCompartido = $this->estuvoCon()->whereNull('hasta')
                ->where('user_id', '=', $user_id)->update(['hasta'=>date("Y-m-d h:i:sa")]);
            //if($tiempoCompartido->hasta - $tiempoCompartido-desde >=  ){
            if($usuario->entrada >= $user->entrada and x_seconds($usuario->entrada, $usuario->salida) and x_seconds($usuario->entrada, $user->salida)){
                $user->agregarVictima($usuario);
                $usuario->agregarVictima($user);
            } elseif ($usuario->entrada < $user->entrada and x_seconds($user->entrada, $usuario->salida) and x_seconds($user->entrada, $user->salida)){
                $user->agregarVictima($usuario);
                $usuario->agregarVictima($user);
            }
            //}
        }

        $this->estuvoCon()->whereNull('hasta')
            ->update(['hasta'=>date("Y-m-d h:i:sa")]);

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

    public function estuvoCon()
    {
        return $this->hasMany(Compartieron::class);
    }

    public function estuvieronJuntos($user_id, $date)
    {
        $entradas_usuario = $this->ingresos()->where('user_id', '=', $user_id)
        ->where('fecha', '>=', $date);

        $estuvieron = array();
        foreach ($this->ingresos()->where('user_id', '<>', $user_id) as $victima){
            foreach ($entradas_usuario as $usuario){
                if ($victima->entrada >= $usuario->entrada and $victima->entrada <= $usuario->salida){
                    if(x_seconds($victima->entrada, $victima->salida) and x_seconds($victima->entrada, $usuario->salida)){
                        array_push($estuvieron, $victima->user_id);
                    }
                } elseif ($victima->salida >= $usuario->entrada and $victima->salida <= $usuario->salida) {
                    if ($victima->entrada >= $usuario->entrada and x_seconds($victima->entrada, $victima->salida) and x_seconds($victima->entrada, $usuario->salida)){
                        array_push($estuvieron, $victima->user_id);
                    } elseif ($victima->entrada < $usuario->entrada and x_seconds($usuario->entrada, $victima->salida) and x_seconds($usuario->entrada, $usuario->salida)){
                        array_push($estuvieron, $victima->user_id);
                    }
                }
            }
        }
        return array_unique($estuvieron);
    }
}
