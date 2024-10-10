<?php

namespace App\Models;

use App\Mail\contagioMail;
use App\Notifications\AvisarContagio;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    protected $guarded = [];

    protected $fillable = [
        'name', 'email', 'password', 'estado', 'locacion', 'is_admin',
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['profile_photo_url'];

    public function locaciones(): HasMany
    {
        return $this->hasMany(Locacion::class);
    }

    public function contagios(): HasMany
    {
        return $this->hasMany(Contagio::class);
    }

    public function victimas(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'victimas', 'user_id', 'victima_id');
    }

    public function puedeIngresarALocacion($locacion): bool
    {
        return $this->locacion == 0 && $this->estado == 'No contagiado' && !$locacion->estaLlena();
    }

    public function noPuedeIngresarPorEstado(): bool
    {
        return $this->estado != 'No contagiado';
    }

    public function estaEnOtraLocacion($locacionId): bool
    {
        return $this->locacion != 0 && $this->locacion != $locacionId;
    }

    public function crearLocacion($request): Locacion
    {
        $locacionService = new LocacionService();
        return $locacionService->createLocacion($this, $request);
    }

    public function contagiar($fecha_minima, $fecha_diagnostico)
    {
        $contagioService = new ContagioService();
        $contagioService->handleContagion($this, $fecha_minima, $fecha_diagnostico);
    }

    public function curado($date)
    {
        $this->estado = 'No contagiado';
        $this->save();
    }

    public function resolverImagen($image_file): ?string
    {
        if ($image_file) {
            $imagen_nombre = time() . '.' . $image_file->getClientOriginalExtension();
            $image_file->move('uploads/locaciones', $imagen_nombre);
            return $imagen_nombre;
        }
        return null;
    }
}
