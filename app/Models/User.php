<?php

namespace App\Models;

use App\Mail\contagioMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'estado',
        'locacion',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function visitas()
    {
        return $this->hasMany(Concurrio::class);
    }

    public function victimas()
    {
        return $this->hasMany(Contagio::class);
    }

//    public function sumarVisita($locacion_id)
//    {
//        $this->visitas()->create([]);
//        $this->locacion = $locacion_id;
//        $this->save();
//    }

    public function locacionesVisitadas($date)
    {
        $locaciones = $this->visitas()->select('locacion_id', 'entrada', 'salida')
            ->distinct('locacion_id')->where('entrada', '>=', $date);

        return $locaciones;
    }

    public function contagiar($date, $fecha_diagnostico)
    {
        $locaciones = $this->locacionesVisitadas($date);

        $en_riesgo = array();
        foreach ($locaciones as $locacion) {
            array_push($en_riesgo, $locacion->estuvieronJuntos($this->id));
        }
        array_merge($en_riesgo);
        array_unique($en_riesgo);

        foreach ($en_riesgo as $victima){
            $victima->estado = 'En riesgo';
            $victima->save();
            $this->victimas()->create(['user_id' => $victima->id,
            'estado' => 'En riesgo',
            'fecha' => date("Y-m-d h:i:sa")]);
            Mail::to($victima->email)->send(new contagioMail());
        }

        if ($this->estado == 'No contagiado') {
            $this->victimas()->create(['user_id'=>$this->id, 'estado'=>'Contagiado',
                'fecha'=>$fecha_diagnostico]);
        } else {
            $this->victimas()->where('user_id', '=', $this->id)->orderBy('id','desc')
                ->first()->fecha = $fecha_diagnostico;
        }

        $this->estado = 'Contagiado';
        $this->save();
    }

    public function curado($date)
    {
        $contagioId = Contagio::all()->where('user_id', '=', $this->id)->sortByDesc('id')
            ->first()->id;
        $contagio = Contagio::find($contagioId);
        $contagio->fecha_alta = $date;
        $contagio->save();

        $this->estado = 'No contagiado';
        $this->save();
    }
}
