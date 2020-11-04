<?php

namespace App\Models;

use App\Mail\contagioMail;
use Carbon\Carbon;
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

    public function crearLocacion($request)
    {
        $imagen_nombre = $this->resolverImagen($request->file('Imagen'));

        $locacion = $this->locaciones()->create([
            'Nombre' => $request->input('Nombre'),
            'Capacidad' => 0,
            'CapacidadMax' => $request->input('CapacidadMax'),
            'Geolocalizacion' => $request->input('Geolocalizacion'),
            'QR' => 'https://qrickit.com/api/qr.php?d=https://yo-estuve-ahi.herokuapp.com/concurrio/',
            'Descripcion' => $request->input('Descripcion'),
            'Imagen' => $imagen_nombre,
            'user_id' => $this->id,
        ]);

        $locacion_id = serialize($locacion->id);
        $locacion_id_encoded = base64_encode($locacion_id);
        $locacion->QR = $locacion->QR.$locacion_id_encoded.'&t=j&qrsize=300';
        $locacion->save();

        return $locacion;
    }

    public function updateLocacion($locacion, $request)
    {
        $imagen_nombre = $this->resolverImagen($request->file('Imagen'));
        $locacion->Nombre = $request->input('Nombre');
        $locacion->CapacidadMax = $request->input('CapacidadMax');
        $locacion->Geolocalizacion = $request->input('Geolocalizacion');
        $locacion->Descripcion = $request->input('Descripcion');
        $locacion->Imagen = $imagen_nombre;
        $locacion->save();

        return $locacion;
    }

    public function contagiar($fecha_minima, $fecha_diagnostico)
    {
        $victimas = $this->victimas()->where('entrada', '>=', $fecha_minima)->get();

        foreach ($victimas as $victima){
            if($victima->estado == 'No contagiado'){
                $victima->update(['estado'=>'En riesgo']);
                $this->contagios()->create(['user_id' => $victima->id,
                    'estado' => 'En riesgo',
                    'fecha' => Carbon::now()]);
                Mail::to($victima->email)->send(new contagioMail());
            }
        }

        if ($this->estado == 'No contagiado') {
            $this->contagios()->create(['user_id'=>$this->id, 'estado'=>'Contagiado',
                'fecha'=>$fecha_diagnostico]);
        } else {
            $this->contagios()->where('user_id', '=', $this->id)->orderBy('id','desc')
                ->first()->fecha = $fecha_diagnostico;
        }

        $this->estado = 'Contagiado';
        $this->save();
    }

    public function curado($date)
    {
        Contagio::all()->where('user_id', '=', $this->id)->sortByDesc('id')
            ->first()->update(['fecha_alta'=>$date]);

        $this->estado = 'No contagiado';
        $this->save();
    }

    public function locaciones()
    {
        return $this->hasMany(Locacion::class);
    }

    public function contagios()
    {
        return $this->hasMany(Contagio::class);
    }

    public function agregarVictima($user)
    {
        return $this->victimas()->attach($user->id, ['entrada'=>Carbon::now()]);
    }

    public function borrarVictima($user)
    {
        return $this->victimas()->detach($user->id);
    }

    public function victimas()
    {
        return $this->belongsToMany(User::class, 'victimas', 'user_id', 'victima_id');
    }

    public function resolverImagen($image_file)
    {
        if($image_file <> null) {
            $extension = $image_file->getClientOriginalExtension();
            $imagen_nombre = time() . '.' . $extension;
            $image_file->move('uploads/locaciones', $imagen_nombre);
            return $imagen_nombre;
        }
        return null;
    }
}
