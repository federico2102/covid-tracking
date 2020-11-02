<?php

namespace Database\Factories;

use App\Models\Locacion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LocacionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Locacion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Nombre' => $this->faker->name,
            'Capacidad' => 0,
            'CapacidadMax' => 10,
            'Geolocalizacion' => Str::random(10), // password
            'QR' => Str::random(10),
            'Descripcion' => Str::random(10),
            'Imagen' => null,
            'user_id' => 0,
        ];
    }
}
